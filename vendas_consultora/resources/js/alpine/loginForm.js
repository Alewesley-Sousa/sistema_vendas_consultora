import { AuthService } from '../service/authService'

import {

    animateCard,
    animateBrand,
    animateForm,
    animateGlow,
    animateInputs,
    animateButtonHover,
    animateButtonLeave,
    animateError,
    animateSuccessTransition,
    animateAurora,

} from '../animations/loginAnimation'

export default () => ({

    email: '',
    password: '',
    loading: false,
    errorMessage: '',
    showPassword: false,
    successTransition: false,

    animateCard,
    animateBrand,
    animateForm,
    animateGlow,
    animateInputs,
    animateButtonHover,
    animateButtonLeave,
    animateError,
    animateAurora,

    async submit() {

        this.loading = true
        this.errorMessage = ''

        try {

            const response =
                await AuthService.login({

                    email: this.email,
                    password: this.password

                })

            if (response.data.token) {

                localStorage.setItem(
                    'auth_token',
                    response.data.token
                )
            }

            // SUCCESS
            this.successTransition = true

            this.$nextTick(() => {

                animateSuccessTransition(

                    this.$refs.card,
                    this.$refs.successOverlay,

                    () => {

                        window.location.href =
                            response.data.redirect

                    }
                )
            })

        } catch (error) {

            console.error(error)

            if (
                error.response?.status === 422
                || error.response?.status === 401
            ) {

                this.errorMessage =
                    'E-mail ou senha inválidos.'

            } else {

                this.errorMessage =
                    'Não foi possível acessar o sistema.'
            }

            this.$nextTick(() => {

                animateError(
                    this.$refs.errorBox
                )

            })

        } finally {

            this.loading = false
        }
    }
})