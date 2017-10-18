$(function(){
	var slider = $('#slider');
	var sliderWrap = $('#slider ul');
	var sliderImg = $('#slider ul li');
	var prevBtm = $('#sliderPrev');
	var nextBtm = $('#sliderNext');
	var length = sliderImg.length;
	var width = sliderImg.width();
	var thumbWidth = width/length;

	sliderWrap.width(width*(length+2));

	//Set up
	slider.after('<div id="' + 'pager' + '"></div>');
	var dataVal = 1;
	sliderImg.each(
		function(){
			$(this).attr('data-img',dataVal);
			$('#pager').append('<a data-img="' + dataVal + '"><img src=' + $('img', this).attr('src') + ' width=' + 106 + '></a>');
		dataVal++;
	});

	//Copy 2 images and put them in the front and at the end
	$('#slider ul li:first-child').clone().appendTo('#slider ul');
	$('#slider ul li:nth-child(' + length + ')').clone().prependTo('#slider ul');

	sliderWrap.css('margin-left', - width);
	$('#slider ul li:nth-child(2)').addClass('active');

	var imgPos = pagerPos = $('#slider ul li.active').attr('data-img');
	$('#pager a:nth-child(' +pagerPos+ ')').addClass('active');


	//Click on Pager
	$('#pager a').on('click', function() {
		pagerPos = $(this).attr('data-img');
		$('#pager a.active').removeClass('active');
		$(this).addClass('active');

		if (pagerPos > imgPos) {
			var movePx = width * (pagerPos - imgPos);
			moveNext(movePx);
		}

		if (pagerPos < imgPos) {
			var movePx = width * (imgPos - pagerPos);
			movePrev(movePx);
		}
		return false;
	});

	//Click on Buttons
	nextBtm.on('click', function(){
		moveNext(width);
		return false;
	});

	prevBtm.on('click', function(){
		movePrev(width);
		return false;
	});

	//Function for pager active motion
	function pagerActive() {
		pagerPos = imgPos;
		$('#pager a.active').removeClass('active');
		$('#pager a[data-img="' + pagerPos + '"]').addClass('active');
	}

	//Function for moveNext Button
	function moveNext(moveWidth) {
		sliderWrap.animate({
    		'margin-left': '-=' + moveWidth
  			}, 500, function() {
  				if (imgPos==length) {
  					imgPos=1;
  					sliderWrap.css('margin-left', - width);
  				}
  				else if (pagerPos > imgPos) {
  					imgPos = pagerPos;
  				}
  				else {
  					imgPos++;
  				}
  				pagerActive();
  		});
	}

	//Function for movePrev Button
	function movePrev(moveWidth) {
		sliderWrap.animate({
    		'margin-left': '+=' + moveWidth
  			}, 500, function() {
  				if (imgPos==1) {
  					imgPos=length;
  					sliderWrap.css('margin-left', -(width*length));
  				}
  				else if (pagerPos < imgPos) {
  					imgPos = pagerPos;
  				}
  				else {
  					imgPos--;
  				}
  				pagerActive();
  		});
	}

});


$(function(){
	var slider2 = $('#slider1');
	var sliderWrap2 = $('#slider1 ul');
	var sliderImg2 = $('#slider1 ul li');
	var prevBtm2 = $('#sliderPrev1');
	var nextBtm2 = $('#sliderNext1');
	var length2 = sliderImg2.length;
	var width2 = sliderImg2.width();
	var thumbWidth2 = width2/length2;

	sliderWrap2.width(width2*(length2+2));

	//Set up
	slider2.after('<div id="' + 'pager1' + '"></div>');
	var dataVal = 1;
	sliderImg2.each(
		function(){
			$(this).attr('data-img',dataVal);
			$('#pager1').append('<a data-img="' + dataVal + '"><img src=' + $('img', this).attr('src') + ' width=' + 106 + '></a>');
		dataVal++;
	});

	//Copy 2 images and put them in the front and at the end
	$('#slider1 ul li:first-child').clone().appendTo('#slider1 ul');
	$('#slider1 ul li:nth-child(' + length2 + ')').clone().prependTo('#slider1 ul');

	sliderWrap2.css('margin-left', - width2);
	$('#slider1 ul li:nth-child(2)').addClass('active');

	var imgPos = pagerPos = $('#slider1 ul li.active').attr('data-img');
	$('#pager1 a:nth-child(' +pagerPos+ ')').addClass('active');


	//Click on Pager
	$('#pager1 a').on('click', function() {
		pagerPos = $(this).attr('data-img');
		$('#pager1 a.active').removeClass('active');
		$(this).addClass('active');

		if (pagerPos > imgPos) {
			var movePx = width2 * (pagerPos - imgPos);
			moveNext(movePx);
		}

		if (pagerPos < imgPos) {
			var movePx = width2 * (imgPos - pagerPos);
			movePrev(movePx);
		}
		return false;
	});

	//Click on Buttons
	nextBtm2.on('click', function(){
		moveNext(width2);
		return false;
	});

	prevBtm2.on('click', function(){
		movePrev(width2);
		return false;
	});

	//Function for pager active motion
	function pagerActive() {
		pagerPos = imgPos;
		$('#pager1 a.active').removeClass('active');
		$('#pager1 a[data-img="' + pagerPos + '"]').addClass('active');
	}

	//Function for moveNext Button
	function moveNext(moveWidth) {
		sliderWrap2.animate({
    		'margin-left': '-=' + moveWidth
  			}, 500, function() {
  				if (imgPos==length2) {
  					imgPos=1;
  					sliderWrap2.css('margin-left', - width2);
  				}
  				else if (pagerPos > imgPos) {
  					imgPos = pagerPos;
  				}
  				else {
  					imgPos++;
  				}
  				pagerActive();
  		});
	}

	//Function for movePrev Button
	function movePrev(moveWidth) {
		sliderWrap2.animate({
    		'margin-left': '+=' + moveWidth
  			}, 500, function() {
  				if (imgPos==1) {
  					imgPos=length2;
  					sliderWrap2.css('margin-left', -(width2*length2));
  				}
  				else if (pagerPos < imgPos) {
  					imgPos = pagerPos;
  				}
  				else {
  					imgPos--;
  				}
  				pagerActive();
  		});
	}

});
