    $(document).ready (function () {
 
        var canvas = $('#game');
        var ctx =  canvas[0].getContext('2d');
        const game_width = $("#game").width();
        const game_height = $("#game").height();
        const paddle_height = 60;
            const paddle_width = 10;
        const paddle_speed=8;
        const ball_max_speed = 30;
 
        var ball_x;
        var ball_y;
        var ball_x_speed;
        var ball_y_speed;
 
        var hits = 0;
 
        var p1_paddle_x = 20;
        var p1_paddle_y = game_height/2-paddle_height/2;
        var p2_paddle_x = game_width-paddle_width-20;
        var p2_paddle_y = game_height/2-paddle_height/2;
 
        var p1_score=0;
        var p2_score=0;
 
        setInterval(draw, 10);
 
        function new_ball() {
            var adjustedHigh = (parseFloat(5) - parseFloat(-5)) + 1;
            var numRand=0;
            while (numRand==0) {
                numRand = Math.floor(Math.random()*adjustedHigh) + parseFloat(-5);
            }
            ball_x_speed = numRand;
            ball_y_speed = numRand;
            hits=0;
            ball_x = 250;
            ball_y = 175;
        }
        function draw() {
            if (!ball_x) new_ball();
            ctx.clearRect(0,0,game_width,game_height);
            ctx.fillStyle = "#fb2";
            ctx.beginPath();
                ctx.rect(0,0,game_width,game_height);
                ctx.closePath();
                ctx.fill();
 
            ctx.shadowOffsetX = 0;
            ctx.shadowOffsetY = 0;
            ctx.shadowBlur = 0;
 
            ctx.textBaseline = "top";
            ctx.fillStyle = "#000";
            ctx.font = "bold 13px sans-serif";
            ctx.fillText("( "+p1_score+" )", 40, 5);
            ctx.fillText("( "+p2_score+" )", game_width-60, 5);
 
            ctx.shadowOffsetX = 2;
            ctx.shadowOffsetY = 5;
            ctx.shadowBlur = 10;
 
            ctx.shadowColor = "black";
            ctx.fillStyle = "#ddd";
            ctx.beginPath();
                ctx.rect(game_width/2-1,0,2,game_height);
                ctx.closePath();
                ctx.fill();
 
            if (ball_x+ball_x_speed>p2_paddle_x)
                if (ball_y+ball_y_speed>=p2_paddle_y && ball_y+ball_y_speed<p2_paddle_y+paddle_height) {
                    ball_x_speed *= -1;
                    hits++;
                }
            if (ball_x+ball_x_speed<=p1_paddle_x+paddle_width)
                if (ball_y+ball_y_speed>p1_paddle_y && ball_y+ball_y_speed<p1_paddle_y+paddle_height) {
                    ball_x_speed *= -1;
                    hits++;
                }
            if (ball_y + ball_y_speed > game_height || ball_y + ball_y_speed < 5)
              ball_y_speed = -ball_y_speed;
            if (ball_x + ball_x_speed > game_width) {
                p1_score++;
                new_ball()
            }
            if (ball_x - ball_x_speed < 0 ) {
                p2_score++;
                new_ball()
            }
            if (hits == 3) {
                if (Math.abs(ball_x_speed) < ball_max_speed && Math.abs(ball_y_speed) < ball_max_speed) {
                    ball_x_speed += 1.3;
                    ball_y_speed *= 1.3;
                    hits = 0;
                }
            }
 
            ball_x += ball_x_speed;
            ball_y += ball_y_speed;
            if (Math.abs(ball_x_speed)<2.5) ball_x_speed*=5;
 
            ctx.fillStyle = "#f55";
            ctx.beginPath();
            ctx.arc(ball_x, ball_y, 10, 0, Math.PI*2, true);
            ctx.closePath();
            ctx.fill();
 
            ctx.fillStyle = "#1e1";
 
            if (ball_x_speed < 0) {
                if (ball_y < p1_paddle_y + paddle_height / 2 && p1_paddle_y>0)
                    p1_paddle_y -= paddle_speed;
                if (ball_y > p1_paddle_y + paddle_height / 2 && p1_paddle_y + paddle_height<game_height)// && act > 4)
                    p1_paddle_y += paddle_speed;
            }
            else {
                if (p1_paddle_y<game_height/2-paddle_height/2) p1_paddle_y += 2;
                else if (p1_paddle_y>game_height/2-paddle_height/2) p1_paddle_y -= 2;
            }
            ctx.beginPath();
                ctx.rect(p1_paddle_x,p1_paddle_y,paddle_width,paddle_height);
                ctx.closePath();
                ctx.fill();
 
            if (ball_x_speed > 0) {
                if (ball_y < p2_paddle_y + paddle_height / 2 && p2_paddle_y>0)
                    p2_paddle_y -= paddle_speed;
                if (ball_y > p2_paddle_y + paddle_height / 2 && p2_paddle_y + paddle_height<game_height)// && act > 4)
                    p2_paddle_y += paddle_speed;
            }
            else {
                if (p2_paddle_y<game_height/2-paddle_height/2) p2_paddle_y += 2;
                else if (p2_paddle_y>game_height/2-paddle_height/2) p2_paddle_y -= 2;
            }
 
            ctx.beginPath();
            ctx.rect(p2_paddle_x,p2_paddle_y,paddle_width,paddle_height);
            ctx.closePath();
            ctx.fill();
 
        }
    })