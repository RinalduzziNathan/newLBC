// init Isotope
var iso = new Isotope( '.sortable-container', {
    itemSelector: '.sortable-item',
    layoutMode: 'fitRows'
});

// filter functions
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
    // if ( !matchesSelector( event.target, 'button' ) ) {
    //   return;
    // }
    var filterValue = event.target.getAttribute('data-filter');
    // use matching filter function
    filterValue = filterFns[ filterValue ] || filterValue;
    iso.arrange({ filter: filterValue });

});

// change active class on buttons
var buttonGroups = document.querySelectorAll('.filters-button-group');


for ( var i=0, len = buttonGroups.length; i < len; i++ ) {
    var buttonGroup = buttonGroups[i];
    radioButtonGroup( buttonGroup );
}

function radioButtonGroup( buttonGroup ) {
    buttonGroup.addEventListener( 'click', function( event ) {
        // only work with buttons
        // if ( !matchesSelector( event.target, 'button' ) ) {
        //   return;
        // }
        console.log(buttonGroup.length);
        buttonGroup.querySelector('.active').classList.remove('active');
        event.target.classList.add('active');
    });
}