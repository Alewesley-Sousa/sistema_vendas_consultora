import './bootstrap'

import Alpine from 'alpinejs'
import gsap from 'gsap'

import loginForm from './alpine/loginForm'

window.Alpine = Alpine
window.gsap = gsap

Alpine.data(
    'loginForm',
    loginForm
)

Alpine.start()