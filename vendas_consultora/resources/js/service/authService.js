import http from './http'

export const AuthService = {

    login(data) {
        return http.post('/login', data)
    }

}