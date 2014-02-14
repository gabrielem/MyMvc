<meta charset="utf-8">
	<script>
	$(function() {
		function log( message ) {
			$( "<div/>" ).text( message ).prependTo( "#log" );
			$( "#log" ).scrollTop( 0 );
		}
		$( "#<%=field_q%>" ).autocomplete({
			source: "<%=source%>",
			minLength: 2,
			select: function( event, ui ) {
                            /* .trim for Cleaning initial space*/
                            $( "#<%=field_q%>" ).val( ui.item.value.trim() );
                            $( "#<%=field_t%>" ).val( ui.item.<%=field_t%> );
                            $( "#<%=field_id_record%>" ).val( ui.item.<%=field_id_record%> );
                            
                            if(ui.item.<%=field_t%>!= 'No-Results')
                            {
                                $( '#<%=form_id%>' ).submit( );
                            }
                            /*
				log( ui.item ?
					"Selected: " + ui.item.value + " aka " + ui.item.id :
					"Nothing selected, input was " + this.value );
                            */
			}
		});
	});
	</script>