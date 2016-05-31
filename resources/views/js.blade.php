if ( typeof(window.Zipcode2Addres) == "undefined" ) {
    var Zipcode2Address = (function(jQuery) {
        var _code_url = '{{ route('getByZipcode') }}';
        var _id_url = '{{ route('getById') }}';
        var _popup = $('<div></div>');

        var _success = function(json) {
            alert(json.prefecture_name + json.city_name + json.name);
        };

        var _selectFunction = function(json) {

            var select = $('<select></select>');
            select.change(function() {
                if ( $(this).val() ) {
                    jQuery.getJSON(_id_url + '?id=' + $(this).val(),function(json) {
                        if ( typeof(json.id) != "undefined" ) {
                            Zipcode2Address.success(json);
                        } else {
                            alert('該当住所が見つかりませんでした');
                        }
                        Zipcode2Address.popup.dialog('destroy').remove();
                    });
                }
            });

            select.append('<option value="">住所を選んでください</option>');

            json.forEach(function(val) {
                select.append("<option value='" + val.id + "'>" + val.prefecture_name + val.city_name + val.name + "</option>");
            });

            Zipcode2Address.popup.dialog({
                open: function() {
                    $(this).append(select);
                },
                close: function() {
                    Zipcode2Address.popup.dialog('destroy').remove();
                },
                title:'住所を選んでください',
            });
        };
        return {
            success: _success,
            selectFunction: _selectFunction,
            popup: _popup,

            init: function(args) {
                if ( typeof(args.success) == "function" ) {
                    this.success = args.success;
                }
                if ( typeof(args.selectFunction) == "function" ) {
                    this.selectFunction = args.selectFunction;
                }
            },
            call: function(code) {
                jQuery.getJSON(_code_url + '?code=' + code,function(json) {
                    if ( json.length == 1 ) {
                        Zipcode2Address.success(json[0]);
                    } else {
                        Zipcode2Address.selectFunction(json);
                    }
                });

            },
        };
    })(jQuery);
}
