const displayType = window.innerWidth > 700 ? 'dayGridMonth' : 'dayGridDay';

window.onload = () => {
    let elementCalendar = document.getElementById("calendar");

    let calendar = new FullCalendar.Calendar(elementCalendar, {

        plugins: ['dayGrid', 'list'],
        locale: 'fr',
        header: {
            left: 'prev, next today',
            center: 'title',
            right: 'dayGridMonth, list'
        },
        defaultView: displayType,
        buttonText: {
            today: 'Aujourd\'hui',
            month: 'Mois',
            list: 'Liste'
        },

        eventClick: function(info) {
            alert('Event: ' + info.event.title);
            alert('Coordinates: ' + info.jsEvent.pageX + ',' + info.jsEvent.pageY);
            alert('View: ' + info.view.type);

            // change the border color just for fun
            info.el.style.borderColor = 'red';
        }
    })

    //calendar.addEvent( event [ source ] );
    calendar.render();
}