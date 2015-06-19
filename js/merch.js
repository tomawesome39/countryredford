/* JavaScript Document
Author: Thomas Clark
Date: 5/25/15
*/

function setVars() {
	// create array of merch pix strings
	var pix = ["cr_coozie.jpg", "cr_sticker.jpg", "cr_shirt.jpg"];
	var timeout;
	var i = 0;
	var img = document.getElementById('merchimg');
	merchShow();
	function merchShow() {
		img.src = "img/" + pix[i];
		i++
		if (i == pix.length) i = 0;
		timeout = window.setTimeout(merchShow, 5000);
	}
}


