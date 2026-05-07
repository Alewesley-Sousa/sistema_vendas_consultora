/**
 * Sistema Moderno de Requisições HTTP - Axios
 * Substitui o java.js legado com validações seguras
 * Data: 30/04/2026
 */

// ============ CONFIGURAÇÃO GLOBAL DE AXIOS ============
const api = axios.create({
    baseURL: '/api',
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
    },
    withCredentials: true
});

// ============ INTERCEPTOR DE ERROS ============
api.interceptors.response.use(
    response => response,
    error => {
        const status = error.response?.status;
        const message = error.response?.data?.message || error.message;
        
        console.error(`[API Error ${status}]`, message);
        
        if (status === 401) {
            showToast('Sessão expirada. Faça login novamente.', 'error');
            window.location.href = '/login';
        } else if (status === 403) {
            showToast('Você não tem permissão para esta ação.', 'warning');
        } else if (status === 422) {
            showToast('Erro de validação. Verifique os dados.', 'error');
        } else {
            showToast(message || 'Erro ao processar requisição.', 'error');
        }
        
        return Promise.reject(error);
    }
);

// ============ NOTIFICAÇÕES (TOAST) ============
function showToast(message, type = 'info') {
    // Remove toast anterior se existir
    const existingToast = document.querySelector('.toast-notification');
    if (existingToast) existingToast.remove();

    const toast = document.createElement('div');
    toast.className = `toast-notification toast-${type}`;
    toast.innerHTML = `
        <div class="toast-content">
            <span class="toast-icon">${getToastIcon(type)}</span>
            <span class="toast-message">${message}</span>
            <button class="toast-close" onclick="this.parentNode.parentNode.remove()">×</button>
        </div>
    `;
    
    document.body.appendChild(toast);
    
    // Auto remover após 4 segundos
    setTimeout(() => toast.remove(), 4000);
}

function getToastIcon(type) {
    const icons = {
        'success': '✓',
        'error': '✕',
        'warning': '⚠',
        'info': 'ℹ'
    };
    return icons[type] || 'ℹ';
}

// Estilos Toast (injetar no <head>)
function injectToastStyles() {
    if (document.querySelector('style[data-toast]')) return;
    
    const style = document.createElement('style');
    style.setAttribute('data-toast', 'true');
    style.textContent = `
        .toast-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            animation: slideIn 0.3s ease;
        }
        
        @keyframes slideIn {
            from { transform: translateX(400px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        @keyframes slideOut {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(400px); opacity: 0; }
        }
        
        .toast-content {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px;
        }
        
        .toast-icon {
            font-weight: bold;
            font-size: 18px;
            flex-shrink: 0;
        }
        
        .toast-message {
            flex: 1;
            font-size: 14px;
        }
        
        .toast-close {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            padding: 0;
            color: inherit;
            opacity: 0.7;
        }
        
        .toast-close:hover { opacity: 1; }
        
        .toast-success {
            background: #10b981;
            color: white;
        }
        
        .toast-error {
            background: #ef4444;
            color: white;
        }
        
        .toast-warning {
            background: #f59e0b;
            color: white;
        }
        
        .toast-info {
            background: #3b82f6;
            color: white;
        }
        
        @media (max-width: 640px) {
            .toast-notification {
                min-width: calc(100% - 40px);
                right: 20px;
                left: 20px;
            }
        }
    `;
    document.head.appendChild(style);
}

// Injetar estilos no carregamento
document.addEventListener('DOMContentLoaded', injectToastStyles);

// ============ UTILITÁRIOS DE VALIDAÇÃO ============

/**
 * Valida email
 */
function isValidEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

/**
 * Valida CPF (básico)
 */
function isValidCPF(cpf) {
    cpf = cpf.replace(/\D/g, '');
    if (cpf.length !== 11) return false;
    
    // Rejeitar sequências repetidas
    if (/^(\d)\1{10}$/.test(cpf)) return false;
    
    return true;
}

/**
 * Valida telefone
 */
function isValidPhone(phone) {
    const re = /^(\d{2})(\d{4,5})(\d{4})$/;
    return re.test(phone.replace(/\D/g, ''));
}

/**
 * Valida CEP
 */
function isValidCEP(cep) {
    const re = /^\d{5}-?\d{3}$/;
    return re.test(cep);
}

// ============ FUNÇÕES DE REQUISIÇÃO HTTP ============

/**
 * GET - Listar recursos
 */
async function fetchList(endpoint, filters = {}) {
    try {
        const response = await api.get(endpoint, { params: filters });
        return response.data;
    } catch (error) {
        console.error('Erro ao listar:', error);
        throw error;
    }
}

/**
 * GET - Obter um recurso
 */
async function fetchOne(endpoint, id) {
    try {
        const response = await api.get(`${endpoint}/${id}`);
        return response.data;
    } catch (error) {
        console.error('Erro ao obter:', error);
        throw error;
    }
}

/**
 * POST - Criar recurso
 */
async function createResource(endpoint, data) {
    try {
        const response = await api.post(endpoint, data);
        return response.data;
    } catch (error) {
        console.error('Erro ao criar:', error);
        throw error;
    }
}

/**
 * PUT - Atualizar recurso
 */
async function updateResource(endpoint, id, data) {
    try {
        const response = await api.put(`${endpoint}/${id}`, data);
        return response.data;
    } catch (error) {
        console.error('Erro ao atualizar:', error);
        throw error;
    }
}

/**
 * DELETE - Deletar recurso
 */
async function deleteResource(endpoint, id) {
    try {
        const response = await api.delete(`${endpoint}/${id}`);
        return response.data;
    } catch (error) {
        console.error('Erro ao deletar:', error);
        throw error;
    }
}

// ============ GERENCIAMENTO DE CARRINHO DE COMPRAS ============

class ShoppingCart {
    constructor() {
        this.items = this.loadFromStorage();
    }

    loadFromStorage() {
        const stored = localStorage.getItem('shopping_cart');
        return stored ? JSON.parse(stored) : [];
    }

    saveToStorage() {
        localStorage.setItem('shopping_cart', JSON.stringify(this.items));
    }

    addItem(produto) {
        const existing = this.items.find(item => item.id === produto.id);
        
        if (existing) {
            existing.quantidade++;
        } else {
            this.items.push({
                id: produto.id,
                nome: produto.nome,
                preco: produto.preco,
                imagem_url: produto.imagem_url,
                quantidade: 1
            });
        }
        
        this.saveToStorage();
        showToast(`${produto.nome} adicionado ao carrinho!`, 'success');
        this.notifyListeners();
    }

    removeItem(productId) {
        this.items = this.items.filter(item => item.id !== productId);
        this.saveToStorage();
        showToast('Produto removido do carrinho', 'info');
        this.notifyListeners();
    }

    updateQuantity(productId, quantity) {
        const item = this.items.find(item => item.id === productId);
        if (item) {
            item.quantidade = Math.max(1, quantity);
            this.saveToStorage();
            this.notifyListeners();
        }
    }

    clear() {
        this.items = [];
        this.saveToStorage();
        this.notifyListeners();
    }

    getTotal() {
        return this.items.reduce((sum, item) => sum + (item.preco * item.quantidade), 0);
    }

    getItemCount() {
        return this.items.reduce((sum, item) => sum + item.quantidade, 0);
    }

    notifyListeners() {
        window.dispatchEvent(new CustomEvent('cartUpdated', { detail: this }));
    }
}

// Instância global do carrinho
const cart = new ShoppingCart();

// ============ HELPER PARA FORMULÁRIOS ============

/**
 * Converte FormData para objeto
 */
function formDataToObject(formData) {
    const obj = {};
    formData.forEach((value, key) => {
        obj[key] = value;
    });
    return obj;
}

/**
 * Submeter formulário via AJAX
 */
async function submitFormAjax(form, endpoint, method = 'POST') {
    try {
        form.classList.add('loading');
        const formData = new FormData(form);
        const data = formDataToObject(formData);

        let response;
        if (method === 'POST') {
            response = await createResource(endpoint, data);
        } else if (method === 'PUT') {
            const id = form.dataset.id;
            response = await updateResource(endpoint, id, data);
        }

        showToast('Salvo com sucesso!', 'success');
        form.reset();
        return response;
    } catch (error) {
        showToast('Erro ao salvar', 'error');
    } finally {
        form.classList.remove('loading');
    }
}

// ============ INICIALIZAÇÃO ============

document.addEventListener('DOMContentLoaded', () => {
    console.log('✓ Sistema moderno de requisições carregado');
    console.log('✓ Validações disponíveis');
    console.log('✓ Carrinho de compras inicializado');
});

// Exportar para uso em outras scripts (se usar módulos)
if (typeof module !== 'undefined' && module.exports) {
    module.exports = { api, showToast, ShoppingCart, cart };
}