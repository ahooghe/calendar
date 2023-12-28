@extends('layouts.app')

@section('content')
	<!-- jQuery and moment.js -->
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
	<!-- FullCalendar CSS -->
	<link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css' rel='stylesheet' />

	<!-- FullCalendar JS -->
	<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js'></script>
	<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/locale/nl.js'></script>
	
	
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
	<style>
	body {
		background-color: #222; /* Change to a color that fits your dark theme */
	}

	.fc-today {
		background-color: #555 !important; /* Change to a color that fits your dark theme */
	}

	.fc-view-container {
	background-color: #333;
	}

	/* Change the color of the text */
	.fc-view-container,
	.fc-widget-header,
	.fc-widget-content {    
	color: #fff;
	}

	.fc-title {
		color: black;
		font-size: 1.2em;
		font-weight: bold;
	}

	/* Change the background color of the header */
	.fc-header-toolbar {    
	background-color: #222;
	color: #fff;
	}
	.modal-content {
	    background-color: #333;
	    color: #E8E8E8;
	    border-color: #444;
	}

	.modal-header,
	.modal-footer {
	    border-color: #444;
	}

	.btn-primary {
	    background-color: #0b5ed7;
	    border-color: #0a58ca;
	}

	.btn-danger {
	    background-color: #dc3545;
	    border-color: #b02a37;
	}

	.btn-secondary {
	    background-color: #6c757d;
	    border-color: #5c636a;
	}
	</style>
	<!-- Div where the calendar will be displayed -->
	<div id='calendar' style="padding: 0px 20px;"></div>
	<div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventModalLabel">Event Details</h5>
            </div>
            <div class="modal-body" id="eventModalBody">
                <!-- Event details will go here -->
            </div>
            <div class="modal-footer">
				<button type="button" class="btn btn-primary" id="signupButton">Inschrijven</button>
				<button id="signoutButton" class="btn btn-danger">Uitschrijven</button>
                <button type="button" class="btn btn-secondary" id="closeModal">Sluiten</button>
            </div>
        </div>
    </div>
</div>
	<script>
		$(document).ready(function() {
			$.ajaxSetup({
    			headers: {
        			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    			}
			});

			$('#calendar').fullCalendar({
				defaultView: 'month',
				aspectRatio: 2.5,
				events: '/events',
				nextDayThreshold: '00:00:00',
				locale: 'nl',
				columnHeaderFormat: 'dddd',
				eventClick: function(info) {
					// Set the title of the modal
					$('#eventModalLabel').text(info.title);

					// Set the body of the modal with the event details
					let startDate = new Date(info.start).toLocaleDateString('nl-BE');
					let endDate = new Date(info.end).toLocaleDateString('nl-BE');
					$('#eventModalBody').html(`
						<p><strong>Start:</strong> ${startDate} ${info.start_time}</p>
						<p><strong>Eind:</strong> ${endDate} ${info.end_time}</p>
						<p><strong>Locatie:</strong> ${info.location}</p>
						<p><strong>Leeftijdsgroep:</strong> ${info.leeftijdsgroep}</p>
						<p><strong>Hoofdanimatoren:</strong> ${info.hoofdAnimatoren}</p>
					`);
					let usersList = info.users.slice(0,info.maxAnimatoren).join(', ');
					$('#eventModalBody').append(`
    					<p><strong>Ingeschreven Animatoren: </strong>${usersList}</p>
					`);
					$('#eventModal').on('show.bs.modal', function (event) {
    					var eventId = info.id;

   						$.post('/check', { activiteiten_id: eventId }, function(response) {
        				if (response.isSignedUp) {
            				$('#signupButton').hide();
            				$('#signoutButton').show();
        				} else {
            				$('#signupButton').show();
            				$('#signoutButton').hide();
        					}
    					});
					});
					// Show the modal
					$('#eventModal').modal('show');
					$('#closeModal').click(function() {
    					$('#eventModal').modal('hide');
					});
					$('#signupButton').off('click').on('click',function() {
    					var eventId = info.id;

    					$.post('/signup', { activiteiten_id: eventId }, function() {
        					toastr.options.timeOut = 2000; // 2 seconds
							toastr.success('Je bent ingeschreven!');
							$('#eventModal').modal('hide');
							$('#calendar').fullCalendar('refetchEvents');
    					});
					});
					$('#signoutButton').off('click').on('click', function() {
    					var eventId = info.id;

    					$.post('/signout', { activiteiten_id: eventId }, function() {
        					toastr.options.timeOut = 2000; // 2 seconds
        					toastr.success('Je bent uitgeschreven!');
							$('#eventModal').modal('hide');
							$('#calendar').fullCalendar('refetchEvents');
    					});
					});
				}
			});
		});
	</script>
@endsection