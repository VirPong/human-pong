var drawingCanvas = document.getElementById('canvasPong');

function initCanvas(){
	// Check the element is in the DOM and the browser supports canvas
	if(drawingCanvas.getContext) {
		//Initaliase a 2-dimensional drawing context
		var context = drawingCanvas.getContext('2d');
		//Canvas commands go here
	}
	drawingCanvas.fillStyle = "#000000";
	drawingCanvas.fillRect(0,0,300,300);
}

