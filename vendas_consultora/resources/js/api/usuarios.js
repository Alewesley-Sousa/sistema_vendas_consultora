export const UsuarioService = {
    async pegarUsuario(id) {
        try {
            // Ajustado para bater com sua rota: /api/usuario/{id}
            const response = await axios.get(`/api/usuario/${id}`);
            return response.data;
        } catch (error) {
            throw error.response ? error.response.data : error;
        }
    },

    async salvar(dados, id = null) {
        try {
            const url = id ? `/api/usuario/${id}` : '/api/usuario';
            
            // Truque do Laravel para PUT em formulários
            const metodo = id ? 'put' : 'post';

            const response = await axios({
                method: metodo, 
                url: url,
                data: dados,
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            });

            return response.data;
        } catch (error) {
            if (!error.response) throw { messagem: "Erro de conexão." };
            throw error.response.data;
        }
    }
}