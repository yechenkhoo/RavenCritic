
const AdminMainList = document.querySelectorAll('#adminMenu button')
AdminMainList.forEach(triggerEl => {
    const tabTrigger = new bootstrap.Tab(triggerEl)

    triggerEl.addEventListener('click', event => {
        event.preventDefault()
        tabTrigger.show()
    })
})

const AdminGameList = document.querySelectorAll('#manageManagerNav button')
AdminGameList.forEach(triggerEl => {
    const tabTrigger = new bootstrap.Tab(triggerEl)

    triggerEl.addEventListener('click', event => {
        event.preventDefault()
        tabTrigger.show()
    })
})

const AdminUserList = document.querySelectorAll('#manageGamesNav button')
AdminUserList.forEach(triggerEl => {
    const tabTrigger = new bootstrap.Tab(triggerEl)

    triggerEl.addEventListener('click', event => {
        event.preventDefault()
        tabTrigger.show()
    })
})

const AdminGenreList = document.querySelectorAll('#manageGenreNav button')
AdminGenreList.forEach(triggerEl => {
    const tabTrigger = new bootstrap.Tab(triggerEl)

    triggerEl.addEventListener('click', event => {
        event.preventDefault()
        tabTrigger.show()
    })
})

const AdminConsoleList = document.querySelectorAll('#manageConsoleNav button')
AdminConsoleList.forEach(triggerEl => {
    const tabTrigger = new bootstrap.Tab(triggerEl)

    triggerEl.addEventListener('click', event => {
        event.preventDefault()
        tabTrigger.show()
    })
})


if (window.location.hash == "#addManager"){
    document.addEventListener('DOMContentLoaded', (event) => {
    var triggerEl = document.querySelector('#adminMenu button[data-bs-target="#managerUser"]');
    var tabInstance = bootstrap.Tab.getInstance(triggerEl);
    if (tabInstance) {
        tabInstance.show();
        var triggerEl = document.querySelector('#manageManagerNav button[data-bs-target="#addManager"]');
        var tabInstance = bootstrap.Tab.getInstance(triggerEl);
        if (tabInstance) {
            tabInstance.show();
        }
    }
});
}

if ((window.location.hash) == "#manageUsers"){
    document.addEventListener('DOMContentLoaded', (event) => {
    var triggerEl = document.querySelector('#adminMenu button[data-bs-target="#managerUser"]');
    var tabInstance = bootstrap.Tab.getInstance(triggerEl);
    if (tabInstance) {
        tabInstance.show();
        var triggerEl = document.querySelector('#manageManagerNav button[data-bs-target="#existingUsers"]');
        var tabInstance = bootstrap.Tab.getInstance(triggerEl);
        if (tabInstance) {
            tabInstance.show();
        }
    }
});
}


if ((window.location.hash).match(/#addGame/)){
    document.addEventListener('DOMContentLoaded', (event) => {
    var triggerEl = document.querySelector('#adminMenu button[data-bs-target="#manageGames"]');
    var tabInstance = bootstrap.Tab.getInstance(triggerEl);
    if (tabInstance) {
        tabInstance.show();
        var triggerEl = document.querySelector('#manageGamesNav button[data-bs-target="#addGame"]');
        var tabInstance = bootstrap.Tab.getInstance(triggerEl);
        if (tabInstance) {
            tabInstance.show();
        }
    }
});
}


if (window.location.hash == "#editGames"){
    document.addEventListener('DOMContentLoaded', (event) => {
    var triggerEl = document.querySelector('#adminMenu button[data-bs-target="#manageGames"]');
    var tabInstance = bootstrap.Tab.getInstance(triggerEl);
    if (tabInstance) {
        tabInstance.show();
        var triggerEl = document.querySelector('#manageGamesNav button[data-bs-target="#editGames"]');
        var tabInstance = bootstrap.Tab.getInstance(triggerEl);
        if (tabInstance) {
            tabInstance.show();
        }
    }
});
}


if (window.location.hash == "#editGenre"){
    document.addEventListener('DOMContentLoaded', (event) => {
    var triggerEl = document.querySelector('#adminMenu button[data-bs-target="#manageGenre"]');
    var tabInstance = bootstrap.Tab.getInstance(triggerEl);
    if (tabInstance) {
        tabInstance.show();
        var triggerEl = document.querySelector('#manageGenreNav button[data-bs-target="#editGenre"]');
        var tabInstance = bootstrap.Tab.getInstance(triggerEl);
        if (tabInstance) {
            tabInstance.show();
        }
    }
});
}

if (window.location.hash == "#addGenre"){
    document.addEventListener('DOMContentLoaded', (event) => {
    var triggerEl = document.querySelector('#adminMenu button[data-bs-target="#manageGenre"]');
    var tabInstance = bootstrap.Tab.getInstance(triggerEl);
    if (tabInstance) {
        tabInstance.show();
        var triggerEl = document.querySelector('#manageGenreNav button[data-bs-target="#addGenre"]');
        var tabInstance = bootstrap.Tab.getInstance(triggerEl);
        if (tabInstance) {
            tabInstance.show();
        }
    }
});
}

if (window.location.hash == "#editConsole"){
    document.addEventListener('DOMContentLoaded', (event) => {
    var triggerEl = document.querySelector('#adminMenu button[data-bs-target="#manageConsole"]');
    var tabInstance = bootstrap.Tab.getInstance(triggerEl);
    if (tabInstance) {
        tabInstance.show();
        var triggerEl = document.querySelector('#manageConsoleNav button[data-bs-target="#editConsole"]');
        var tabInstance = bootstrap.Tab.getInstance(triggerEl);
        if (tabInstance) {
            tabInstance.show();
        }
    }
});
}


if (window.location.hash == "#addConsole"){
    document.addEventListener('DOMContentLoaded', (event) => {
    var triggerEl = document.querySelector('#adminMenu button[data-bs-target="#manageConsole"]');
    var tabInstance = bootstrap.Tab.getInstance(triggerEl);
    if (tabInstance) {
        tabInstance.show();
        var triggerEl = document.querySelector('#manageConsoleNav button[data-bs-target="#addConsole"]');
        var tabInstance = bootstrap.Tab.getInstance(triggerEl);
        if (tabInstance) {
            tabInstance.show();
        }
    }
});
}

