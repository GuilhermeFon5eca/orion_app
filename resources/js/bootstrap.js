import 'bootstrap';

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
window.Pusher = Pusher;
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: '',
    // wsHost: import.meta.env.VITE_PUSHER_HOST ?? `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
    // wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
    wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws'],
    forceTLS: false,
    encrypted: true,
    disableStats: true,

    wsHost: window.location.hostname,
    wsPort: 6001,
    auth: {
        headers: {
            Authorization: 'Bearer '+get_token(),
            Accept: "application/json",
        },
    },
});

window.Echo.channel('DemoChannel')
    .listen('WebsocketDemoEvent', (e)=>{
        console.log(e);
    })

function get_token(){
    let token = document.cookie.split(';').find(indice =>{
        return indice, indice.includes('token=');
    });
    if(token){
        token = token.split('=')[1];
        return token;
    }   
}

/*interceptar os requests da aplicação*/
axios.interceptors.request.use(
    config =>{
        //Definir accept e auth para todas as requisições
        config.headers['Accept'] = 'application/json'
        
        //Recuperando token dos cookies
        let token = document.cookie.split(';').find(index =>{
            return index, index.includes('token=');
        });
        token = token.split('=')[1];
        token = 'Bearer '+token;
        
        config.headers.Authorization = token
        
        
        return config
    },
    error =>{
        return Promise.reject(error)
    }
)
/*interceptar os responses da aplicação*/
axios.interceptors.response.use(
    response =>{
        return response
    },
    error =>{
        if(error.response.status == 401 && error.response.data.message == 'Token has expired'){
            axios.post('http://127.0.0.1:8000/api/refresh')
            .then(response =>{
                document.cookie = 'token='+response.data.token+';SameSite=Lax';
                window.location.reload();
            })
        }
        return Promise.reject(error)
    }
)
    
