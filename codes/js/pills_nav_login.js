const triggerTabList = document.querySelectorAll('#loginRegisterNav button')
triggerTabList.forEach(triggerEl => {
    const tabTrigger = new bootstrap.Tab(triggerEl)

    triggerEl.addEventListener('click', event => {
        event.preventDefault()
        tabTrigger.show()
    })
})

if (window.location.hash == "#register"){
document.addEventListener('DOMContentLoaded', (event) => {
    var triggerEl = document.querySelector('#loginRegisterNav button[data-bs-target="#pills-register"]');
    var tabInstance = bootstrap.Tab.getInstance(triggerEl);
    if (tabInstance) {
        tabInstance.show();
    }
});
}