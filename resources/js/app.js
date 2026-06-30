require('./bootstrap');


console.log("APP JS LOADED");

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// 🔥 Catch ALL fetch() errors (modern JS)
(function () {
    const originalFetch = window.fetch;

    window.fetch = function () {
        return originalFetch.apply(this, arguments)
            .then(async response => {

                if (response.status === 419) {
                    console.log("419 detected via fetch");

                    let data;
                    try {
                        data = await response.clone().json();
                    } catch (e) {}

                    if (data && data.redirect) {
                        alert(data.message || 'Session expired');
                        window.location.href = data.redirect;
                    } else {
                        window.location.href = '/login';
                    }
                }

                return response;
            });
    };
})();

// 🔥 Global handler for session expired (works for Axios)
window.axios.interceptors.response.use(
    function(response) {
        // If response is successful, just return it
        return response;
    },
    function(error) {
        // Check if backend sent session expired info
        if (error.response) {
            // If Laravel sent redirect URL in JSON
            if (error.response.data && error.response.data.redirect) {
                alert(error.response.data.message || 'Session expired');
                window.location.href = error.response.data.redirect;
            } 
            // Optional: fallback if 419 but no redirect key
            else if (error.response.status === 419) {
                alert('Session expired. Reloading page...');
                window.location.reload();
            }
        }
        return Promise.reject(error);
    }
);