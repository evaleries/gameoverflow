<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Error - {{code}}</title>

    <link href="https://fonts.googleapis.com/css?family=Quicksand:700" rel="stylesheet">

    <style>
        * {
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
        }

        body {
            font-family: 'Quicksand', sans-serif;
            padding: 0;
            margin: 0;
        }

        pre {
            box-sizing: border-box;
            width: 100%;
            padding: 0;
            margin: 0;
            overflow: auto;
            overflow-y: hidden;
            font-size: 12px;
            line-height: 20px;
            background: #efefef;
            border: 1px solid #777;
            padding: 10px;
            color: #333;
        }

        #notfound {
            position: relative;
            height: 100vh;
            background-color: #fafbfd;
        }

        #notfound .notfound {
            position: absolute;
            left: 50%;
            top: 50%;
            -webkit-transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
        }

        .notfound {
            max-width: 520px;
            width: 100%;
            text-align: center;
        }

        .notfound .notfound-bg {
            position: absolute;
            left: 0px;
            right: 0px;
            top: 50%;
            -webkit-transform: translateY(-50%);
            -ms-transform: translateY(-50%);
            transform: translateY(-50%);
            z-index: -1;
        }

        .notfound .notfound-bg > div {
            width: 100%;
            background: #fff;
            border-radius: 90px;
            height: 125px;
        }

        .notfound .notfound-bg > div:nth-child(1) {
            -webkit-box-shadow: 5px 5px 0px 0px #f3f3f3;
            box-shadow: 5px 5px 0px 0px #f3f3f3;
        }

        .notfound .notfound-bg > div:nth-child(2) {
            -webkit-transform: scale(1.3);
            -ms-transform: scale(1.3);
            transform: scale(1.3);
            -webkit-box-shadow: 5px 5px 0px 0px #f3f3f3;
            box-shadow: 5px 5px 0px 0px #f3f3f3;
            position: relative;
            z-index: 10;
        }

        .notfound .notfound-bg > div:nth-child(3) {
            -webkit-box-shadow: 5px 5px 0px 0px #f3f3f3;
            box-shadow: 5px 5px 0px 0px #f3f3f3;
            position: relative;
            z-index: 90;
        }

        .notfound h1 {
            font-family: 'Quicksand', sans-serif;
            font-size: 86px;
            text-transform: uppercase;
            font-weight: 700;
            margin-top: 0;
            margin-bottom: 8px;
            color: #151515;
        }

        .notfound h2 {
            font-family: 'Quicksand', sans-serif;
            font-size: 26px;
            margin: 0;
            font-weight: 700;
            color: #151515;
        }

        .notfound a {
            font-family: 'Quicksand', sans-serif;
            font-size: 14px;
            text-decoration: none;
            text-transform: uppercase;
            background: #18e06f;
            display: inline-block;
            padding: 15px 30px;
            border-radius: 5px;
            color: #fff;
            font-weight: 700;
            margin-top: 20px;
        }

        @media only screen and (max-width: 767px) {
            .notfound .notfound-bg {
                width: 287px;
                margin: auto;
            }

            .notfound .notfound-bg > div {
                height: 85px;
            }
        }

        @media only screen and (max-width: 480px) {
            .notfound h1 {
                font-size: 68px;
            }

            .notfound h2 {
                font-size: 18px;
            }
        }
    </style>

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div id="notfound">
    <div class="notfound">
        <div class="notfound-bg">
            <div></div>
            <div></div>
            <div></div>
        </div>
        <h1>oops!</h1>
        <h2>Error - {{code}}</h2>
        <pre>{{ message }}</pre>
        <a href="javascript:history.back()">go back</a>
        <p>GameOverFlow</p>
    </div>
</div>

</html>
