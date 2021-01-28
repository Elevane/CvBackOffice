let about = document.getElementById('about');
let skills = document.getElementById('skills');
let projects = document.getElementById('projects');
let blog = document.getElementById('blog');
let contact = document.getElementById('contact');
let filters = document.getElementById('filters')

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

//Handle dynamic skills bars
	var triggerAtY = skills.offsetTop - window.outerHeight;

	window.addEventListener('scroll',function (event) {
		// #target not yet in view
		if (triggerAtY > window.offsetTop) {
			return;
		}
		var elm = document.querySelector('.ratioSkill');
		for(var i = 0; i< elm.length; i ++){
			elm[i].querySelector('div').animate({
				width: this.getAttribute('data-percent') * 4
			}, 1500);
		}
		// remove his event handler

	});

/**
 * Librairie de gestion du filtrage des projets
 */
var iso = new Isotope( '.ulpro', {
	itemSelector: '.element-item',
	layoutMode: 'fitRows'
});

var filterFns = {
	// show if number is greater than 50
	numberGreaterThan50: function( itemElem ) {
		var number = itemElem.querySelector('.number').textContent;
		return parseInt( number, 10 ) > 50;
	},
	// show if name ends with -ium
	ium: function( itemElem ) {
		var name = itemElem.querySelector('.name').textContent;
		return name.match( /ium$/ );
	}
};

// bind filter button click
var filtersElem = document.querySelector('.filters-button-group');
filtersElem.addEventListener( 'click', function( event ) {
	// only work with buttons
	if ( !matchesSelector( event.target, 'button' ) ) {
		return;
	}
	var filterValue = event.target.getAttribute('data-filter');
	// use matching filter function
	filterValue = filterFns[ filterValue ] || filterValue;
	iso.arrange({ filter: filterValue });
});

// change is-checked class on buttons
var buttonGroups = document.querySelectorAll('.button-group');
for ( var i=0, len = buttonGroups.length; i < len; i++ ) {
	var buttonGroup = buttonGroups[i];
	radioButtonGroup( buttonGroup );
}

function radioButtonGroup( buttonGroup ) {
	buttonGroup.addEventListener( 'click', function( event ) {
		// only work with buttons
		if ( !matchesSelector( event.target, 'button' ) ) {
			return;
		}
		buttonGroup.querySelector('.is-checked').classList.remove('is-checked');
		event.target.classList.add('is-checked');
	});
}


