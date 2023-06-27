<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PersonaChat</title>
    <script src="r.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;700&family=DM+Sans:wght@400;500;600;700;800&display=swap');
        html {
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Instrument Sans', sans-serif;
            margin: 0;
            padding: 0;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'DM Sans', sans-serif;
        }
        .header {
            background: #0073FF;
            color: white;
            padding: 15px 25px;
            display: flex;
            align-items: center;
        }
        .header .title {
            font-weight: bold;
        }
        .header .space {
            flex-grow: 1;
        }
        .hero {
            background: #EFF6FF;
            padding: 10px 35px;
            margin: 35px 25px;
            border-radius: 15px;
            color: #003679;
        }
        .hero .em {
            color: #0063DD;
        }
        .footer {
            background: #393939;
            color: white;
            padding: 10px 25px;
        }
        .footer a {
            color: white;
        }
    </style>
</head>
<body>
    <div class="header">
        <span class="title">PersonaChat</span>
        <span class="spacer"></span>
    </div>
    <div class="hero">
        <h1>PersonaChat</h1>
        <h2>Chat with your own <span class="em">personalized</span> AI persona!</h2>
    </div>
    <div class="footer">
        <p>&copy; 2023 PersonaChat. All rights reserved. PersonaChat is an <a href="https://github.com/personachat/PersonaChat" target="_blank">open-sourced project</a>!</p>
    </div>
</body>
</html>