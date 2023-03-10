function active() {
    $(document).ready(function() {
        $( ".topnav a" ).bind( "click", function(event) {
            event.preventDefault();
            var clickedItem = $( this );
            $( ".topnav a" ).each( function() {
                $( this ).removeClass( "active" );
            });
            clickedItem.addClass( "active" );
        });
    });
}