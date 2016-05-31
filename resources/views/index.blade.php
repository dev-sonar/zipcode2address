<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>郵便番号検索</title>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body role="document">
<div class="container">
    <div class="page-header">
        <h1>郵便番号検索</h1>
    </div>

<p>郵便番号を入力してください</p>
        <div class="input-group">
            <span class="input-group-addon">郵便番号</span>
            <input name="zipcode" type="zipcode" class="form-control" placeholder="例）1234567">
            <span class="input-group-btn">
                <button id="zipcodeSearch" type="button" class="btn btn-default">探す</button>
            </span>
        </div>

<div class="panel panel-default" style="margin-top:40px">
    <p id="address"></p>
</div>
        
</div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
        <script src="{{ url('zipcode2address.js') }}"></script>
<script type="text/javascript">
$(document).ready(function() {
        Zipcode2Address.init({success: function(json) {
            $('#address').text(json.prefecture_name+json.city_name,json.name);
        }});
    
    $('#zipcodeSearch').click(function() {
        Zipcode2Address.call($('input[name=zipcode]').val());
    });
});
</script>
    </body>
</html>
