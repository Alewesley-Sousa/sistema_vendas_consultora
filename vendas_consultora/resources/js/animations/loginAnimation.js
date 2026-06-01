import { gsap } from 'gsap'

export function animateCard(el) {
    gsap.from(el, {
        opacity: 0,
        scale: .94,
        duration: .8,
        ease: 'power3.out'
    })
}

export function animateBrand(panel) {
    // Se não receber o painel (Alpine antigo), busca no documento global
    const scope = panel || document
    
    if (panel) {
        gsap.from(panel, {
            x: -80,
            opacity: 0,
            duration: 1,
            delay: .2,
            ease: 'power3.out'
        })
    }

    gsap.from(scope.querySelectorAll('.brand-item'), {
        opacity: 0,
        y: 25,
        stagger: .12,
        duration: .7,
        delay: .45,
        ease: 'power2.out'
    })
}

export function animateForm(el) {
    gsap.from(el, {
        x: 80,
        opacity: 0,
        duration: .9,
        delay: .25,
        ease: 'power3.out'
    })
}

export function animateInputs(panel) {
    const scope = panel || document

    gsap.from(scope.querySelectorAll('.login-input'), {
        opacity: 0,
        y: 20,
        stagger: .15,
        duration: .6,
        delay: .7,
        ease: 'power2.out'
    })
}

export function animateGlow() {
    gsap.to('.login-glow', {
        y: 25,
        duration: 4,
        repeat: -1,
        yoyo: true,
        ease: 'sine.inOut',
        stagger: 1
    })
}

export function animateButtonHover(el) {
    gsap.to(el, {
        scale: 1.03,
        y: -3,
        duration: .25,
        ease: 'power2.out'
    })
}

export function animateButtonLeave(el) {
    gsap.to(el, {
        scale: 1,
        y: 0,
        duration: .25,
        ease: 'power2.out'
    })
}

export function animateError(el) {
    if (!el) return
    
    gsap.fromTo(el,
        { opacity: 0, y: -10, scale: .95 },
        { opacity: 1, y: 0, scale: 1, duration: .45, ease: 'back.out(1.7)' }
    )

    gsap.fromTo(el,
        { x: -8 },
        { x: 8, duration: .05, repeat: 5, yoyo: true }
    )
}

export function animateSuccessTransition(card, overlay, callback) {
    const tl = gsap.timeline({ onComplete: callback })

    tl.to(card, {
        scale: .92,
        opacity: 0,
        filter: 'blur(10px)',
        duration: .55,
        ease: 'power3.inOut'
    })
    .fromTo(overlay,
        { opacity: 0, scale: .9 },
        { opacity: 1, scale: 1, duration: .45, ease: 'power3.out' },
        '-=.2'
    )
    .to(overlay, {
        scale: 1.04,
        duration: .8,
        yoyo: true,
        repeat: 1,
        ease: 'sine.inOut'
    })
}

// Retornamos a função para o Alpine parar de chorar erro no console!
export function animateAurora() {
    gsap.to('[x-ref="aurora1"]', {
        x: 80,
        y: 35,
        duration: 10,
        repeat: -1,
        yoyo: true,
        ease: 'sine.inOut'
    })

    gsap.to('[x-ref="aurora2"]', {
        x: -70,
        y: 50,
        duration: 12,
        repeat: -1,
        yoyo: true,
        ease: 'sine.inOut'
    })

    gsap.to('[x-ref="aurora3"]', {
        x: 50,
        y: -40,
        scale: 1.18,
        duration: 14,
        repeat: -1,
        yoyo: true,
        ease: 'sine.inOut'
    })

    gsap.to('[x-ref="aurora4"]', {
        x: -45,
        y: -30,
        scale: .9,
        duration: 11,
        repeat: -1,
        yoyo: true,
        ease: 'sine.inOut'
    })
}