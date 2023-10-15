let show = true;
(function() {
    let unitModals = document.querySelectorAll('.unitModal');

    unitModals.forEach(unitModal => {
        unitModal.addEventListener('click', function handleClick(event) {
            event.preventDefault();
            console.log(unitModal.id, event);
        });
    });

})();