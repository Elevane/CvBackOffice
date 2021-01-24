let about = document.getElementById('about');
let skills = document.getElementById('skills');
let projects = document.getElementById('projects');
let blog = document.getElementById('blog');
let contact = document.getElementById('contact');


var btnabout = document.getElementById('aabout');
btnabout.addEventListener('click', function(){
    about.scrollIntoView({behavior: "smooth"});
})

var btnskills = document.getElementById('askills');
btnskills.addEventListener('click', function(){
	skills.scrollIntoView({behavior: "smooth"});
})

var btnscontactmebtn = document.getElementById('contactmebtn');
btnscontactmebtn.addEventListener('click', function () {
	contact.scrollIntoView({ behavior: "smooth" });
})

var btnprojects = document.getElementById('aprojects');
btnprojects.addEventListener('click', function(){
	projects.scrollIntoView({behavior: "smooth"});
})

var btnblog = document.getElementById('ablog');
btnblog.addEventListener('click', function(){
	blog.scrollIntoView({behavior: "smooth"});
})

var btncontact = document.getElementById('acontact');
 btncontact.addEventListener('click', function(){
	contact.scrollIntoView({behavior: "smooth"});
})


// handle see more/less of projects and blog sections
	var fullheight = $('#projects article')[0].scrollHeight + 300 + "px";
	var originalheight = $('#projects').height();
	$('#showmorepro').on('click', function () {
		if ($('#showmorepro').hasClass("less")) {
			$('#showmorepro').removeClass('less');
		
			$('#projects').animate({
				height: fullheight
			}, 1000, function () {
				//animation complete
				$('#showmorepro').find('img').attr('src', "img/arrow_up.png");
				$('#showmorepro').addClass('more');
					
			});
		
		}
		else if ($('#showmorepro').hasClass("more")) {
			$('#showmorepro').removeClass('more');
			$('#projects').animate({
				height: originalheight
			}, 1000, function () {
				//animation complete
				$('#showmorepro').find('img').attr('src', "img/arrow_down.png");
				$('#showmorepro').addClass('less');
					
			});
		
		}
	
	});

	var blogfullheight = $('#blog article')[0].scrollHeight + 300 + "px";
	var blogoriginalheight = $('#blog').height();
	$('#showmoreblog').on('click', function () {
		if ($('#showmoreblog').hasClass("less")) {
			$('#showmoreblog').removeClass('less');

			$('#blog').animate({
				height: blogfullheight
			}, 1000, function () {
				//animation complete
				$('#showmoreblog').find('img').attr('src', "img/arrow_up.png");
				$('#showmoreblog').addClass('more');

			});

		}
		else if ($('#showmoreblog').hasClass("more")) {
			$('#showmoreblog').removeClass('more');
			$('#blog').animate({
				height: blogoriginalheight
			}, 1000, function () {
				//animation complete
				$('#showmoreblog').find('img').attr('src', "img/arrow_down.png");
				$('#showmoreblog').addClass('less');

			});

		}

	});

//Handle dynamic skills bars
	var triggerAtY = $('#skills').offset().top - $(window).outerHeight();

	$(window).scroll(function (event) {
		// #target not yet in view
		if (triggerAtY > $(window).scrollTop()) {
			return;
		}


		var elm = $('.ratioSkill');
		console.log('scrolling');
		elm.each(function () {
			jQuery(this).find('div').animate({
				width: jQuery(this).attr('data-percent') * 4
			}, 1500);
		});


		// remove this event handler
		$(this).off(event);
	})

////////////////////////////////////////////////////////////////////////////////////////////
// quick search regex
var qsRegex;
var buttonFilter;

// init Isotope
var $grid = $('.ulpro').isotope({
	itemSelector: '.pro',
	layoutMode: 'fitRows',
	filter: function () {
		var $this = $(this);
		var searchResult = qsRegex ? $this.text().match(qsRegex) : true;
		var buttonResult = buttonFilter ? $this.is(buttonFilter) : true;
		return searchResult && buttonResult;
	}
});

$('#filters').on('click', 'button', function () {
	buttonFilter = $(this).attr('data-filter');
	$grid.isotope();
});

// use value of search field to filter
var $quicksearch = $('#quicksearch').keyup(debounce(function () {
	qsRegex = new RegExp($quicksearch.val(), 'gi');
	$grid.isotope();
}));


// change is-checked class on buttons
$('.button-group').each(function (i, buttonGroup) {
	var $buttonGroup = $(buttonGroup);
	$buttonGroup.on('click', 'button', function () {
		$buttonGroup.find('.is-checked').removeClass('is-checked');
		$(this).addClass('is-checked');
	});
});


// debounce so filtering doesn't happen every millisecond
function debounce(fn, threshold) {
	var timeout;
	threshold = threshold || 100;
	return function debounced() {
		clearTimeout(timeout);
		var args = arguments;
		var _this = this;
		function delayed() {
			fn.apply(_this, args);
		}
		timeout = setTimeout(delayed, threshold);
	};
}