<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>SuperStar South Studios</title>
    <link rel="stylesheet" href="/styles.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
</head>

<body>

    <header class="header">
        <div class="container">
            <svg viewBox="0 0 420 100" preserveAspectRatio="xMidYMid meet" style="user-select: none">
                <defs>
                    <!-- Define linear gradient -->
                    <linearGradient id="textGradient" x1="0%" y1="0%" x2="0%" y2="100%">
                        <stop offset="50%" stop-color="#ffffff" />
                        <stop offset="90%" stop-color="#fffde7" />
                    </linearGradient>
                    <linearGradient id="textGradient2" x1="0%" y1="0%" x2="0%" y2="100%">
                        <stop offset="10%" stop-color="#ffc107" />
                        <stop offset="100%" stop-color="#ffeb3b" />
                    </linearGradient>
                    <!-- Define linear gradient for text outline -->
                    <linearGradient id="outlineGradient" x1="0%" y1="50%" x2="100%" y2="100%">
                        <stop offset="10%" stop-color="#ff9800" />
                        <stop offset="30%" stop-color="#76ff03" />
                        <stop offset="45%" stop-color="#80d8ff" />
                        <stop offset="80%" stop-color="#ec407a" />
                    </linearGradient>
                    <!-- Define the "PT Sans" font -->
                    <style>
                        @import url('https://fonts.cdnfonts.com/css/pricedown');

                        .gradientText {
                            font-family: 'Pricedown Bl';
                            font-size: 36px;
                            font-weight: bold;
                            fill: url(#textGradient);
                        }

                        .gradientText.outline {
                            fill: none;
                            stroke: url(#outlineGradient);
                            stroke-width: 5;
                        }

                        .gradientText.outlineB {
                            fill: none;
                            stroke: black;
                            stroke-width: 2.5;
                        }
                    </style>
                </defs>
                <text x="10" y="60" class="gradientText outline">Superstar South Studios</text>
                <text x="10" y="60" class="gradientText outlineB">Superstar South Studios</text>
                <text x="10" y="60" class="gradientText">Superstar South <tspan style="fill: url(#textGradient2)">Studios</tspan></text>
            </svg>
        </div>
    </header>
    <nav class="navbar">
        <div class="container">
            <ul>
                <a href="/">Home</a>
                <a href="/posts">Devlog</a>
            </ul>
        </div>
    </nav>

    <div class="container" style="min-height: 50vh">