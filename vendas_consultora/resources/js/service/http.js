import axios from 'axios'

const http = axios.create({

    headers: {
        'X-Requested-With': 'XMLHttpRequest'
    },

    withCredentials: true

})

const token =
    document
        .querySelector(
            'meta[name="csrf-token"]'
        )
        ?.getAttribute('content')

if (token) {

    http.defaults.headers.common[
        'X-CSRF-TOKEN'
    ] = token

}

http.interceptors.response.use(

    response => response,

    error => {

        console.error(
            'HTTP Error:',
            error
        )

        return Promise.reject(error)
    }

)

export default http