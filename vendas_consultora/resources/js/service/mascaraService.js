export const MascaraService = {
    cpf(value) {
        return value
            .replace(/\D/g, '') // Remove tudo que não é número
            .replace(/(\d{3})(\d)/, '$1.$2') // Coloca ponto após o terceiro dígito
            .replace(/(\d{3})(\d)/, '$1.$2') // Coloca ponto após o sexto dígito
            .replace(/(\d{3})(\d{1,2})$/, '$1-$2') // Coloca hífen após o nono dígito
            .substring(0, 14); // Limita o tamanho da string formatada
    },

    telefone(value) {
        return value
            .replace(/\D/g, '')
            .replace(/^(\d{2})(\d)/g, '($1) $2') // Coloca parênteses no DDD
            .replace(/(\d{5})(\d)/, '$1-$2') // Formato celular (85) 99999-9999
            .substring(0, 15);
    },

    cep(value) {
        return value
            .replace(/\D/g, '')
            .replace(/(\d{5})(\d)/, '$1-$2') // Formato 60000-000
            .substring(0, 9);
    }
};