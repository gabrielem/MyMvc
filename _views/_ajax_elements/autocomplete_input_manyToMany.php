<meta charset="utf-8">
	<script>
	//$( "#<%=field_q%>" )
	$(function() {
		function split( val ) {
			return val.split( /,\s*/ );
		}
		function extractLast( term ) {
			return split( term ).pop();
		}

		$( "#<%=field_q%>" )
			// don't navigate away from the field on tab when selecting an item
			.bind( "keydown", function( event ) {
				if ( event.keyCode === $.ui.keyCode.TAB &&
						$( this ).data( "autocomplete" ).menu.active ) {
					event.preventDefault();
				}
			})
			.autocomplete({
				source: function( request, response ) {
					$.getJSON( "<%=source%>", {
						//term: extractLast( request.term )
                                                
                                                term:extractLast(request.term)
                                                //id_record:extractLast(request.id_record)
                                                
                                                
					}, response );
				},
				search: function() {
					// custom minLength
					var term = extractLast( this.value );
                                        //var id_record = extractLast( this.id_record );
                                        
					if ( term.length < 2 ) {
						return false;
					}
				},
				focus: function() {
					// prevent value inserted on focus
					return false;
				},
				select: function( event, ui ) {
					var terms = split( this.value );
					// remove the current input
					terms.pop();
					// add the selected item
					terms.push( ui.item.value );
                                        //id_record.push( ui.item.id_record );
                                        
					// add placeholder to get the comma-and-space at the end
					terms.push( "" );
                                        //id_record.push( "" );
                                        
					this.value = terms.join( "," );
					//this.value = id_record.join( ", " );
					
                                        return false;
				}
			});
	});
	</script>