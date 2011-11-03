<!--<!doctype html>
<html>
  <head>
    <title>VirPong: Live - Version 0.2</title> -->
	<?php
	session_start();
	include_once('./header.php');
?>
    <!-- Required includes -->
    <script src="lib/socket.io.js"></script>
    <script src="client.js"></script>
    <!-- Get the pong game javascript file -->
    <!-- <script src="pongGame.js"></script> -->
    <!-- Trial javascript include -->
    <!-- Taking ours out. Testing against the originals
    <script src="gameMechanicsTrial.js"></script>
    <script src="renderTrial.js"></script>
    -->
    <!-- Pong include -->
    <!-- <script src="pongInclude.js"></script> -->
    <!-- Second try -->
    <!-- <scipt src="pongRender.js"></script> -->
    <script src="pongRender3.js"></script>


    <div id="outer">
	<div>
      <canvas id="canvas" width="640" height="480"> This text is diplayed if your browser does not support HTML5 Canvas. Unfortunaley, this means that you cannot watch VirPong:Live. Please update your browser, or download a browser that supports HTML5 Canvas (Link to System Requirements here).</canvas>
	</div>
	<!-- First attempt at changing values within tags 
	<p id="demo"> Random Text. </p>
	<button type="button" onclick="displayTime()"> Display time</button>
	-->
      <div id="hud">
        <div id="buttons">
          <button id="join">Join</button>
        </div>

        <div id="info">
          <div>
            <span id="observer-count">0</span> observers.
          </div>
          <div>
            <span id="average-lag">0</span> X Position.
          </div>
	  <div>
	    <span id="time-stamp">0</span> time - stamp.
	  </div>
	    <span id="YCoord">0</span> Y position.
	  <div>
	  </div>
        </div>
      </div>
    </div>
  <?php
	include_once($footer);
?>
<!-- </html> -->