// firebase-config.js

// Importe o Firebase SDK
import { initializeApp } from "https://www.gstatic.com/firebasejs/10.0.0/firebase-app.js";
import { getFirestore, collection, addDoc } from "https://www.gstatic.com/firebasejs/10.0.0/firebase-firestore.js";

// Configuração do Firebase - Substitua com suas credenciais
const firebaseConfig = {
    apiKey: "SUA_API_KEY",
    authDomain: "SEU_PROJETO.firebaseapp.com",
    projectId: "SEU_PROJETO_ID",
    storageBucket: "SEU_PROJETO.appspot.com",
    messagingSenderId: "SEU_SENDER_ID",
    appId: "SEU_APP_ID"
};

// Inicialize o Firebase
const app = initializeApp(firebaseConfig);
const db = getFirestore(app);

// Referência para a coleção 'membros'
const membrosRef = collection(db, "membros");

// Aguarde o DOM carregar completamente
document.addEventListener('DOMContentLoaded', function() {
    const cadastroForm = document.getElementById('cadastroForm');
    
    if (cadastroForm) {
        cadastroForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            // Mostrar carregamento
            const submitBtn = cadastroForm.querySelector('.btn-cadastro');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enviando...';
            submitBtn.disabled = true;
            
            try {
                // Coletar dados do formulário
                const formData = {
                    nome: document.getElementById('nome').value,
                    email: document.getElementById('email').value,
                    telefone: document.getElementById('telefone').value,
                    dataNascimento: document.getElementById('dataNascimento').value || null,
                    estadoCivil: document.getElementById('estadoCivil').value || '',
                    comoConheceu: document.getElementById('comoConheceu').value || '',
                    endereco: document.getElementById('endereco').value || '',
                    observacoes: document.getElementById('observacoes').value || '',
                    newsletter: document.getElementById('newsletter').checked,
                    dataCadastro: new Date().toISOString(),
                    status: 'novo'
                };
                
                // Adicionar documento ao Firestore
                const docRef = await addDoc(membrosRef, formData);
                
                // Mostrar mensagem de sucesso
                mostrarMensagem('Cadastro realizado com sucesso! Em breve entraremos em contato.', 'sucesso');
                
                // Limpar formulário
                cadastroForm.reset();
                
                console.log("Documento escrito com ID: ", docRef.id);
                
            } catch (error) {
                console.error("Erro ao adicionar documento: ", error);
                mostrarMensagem('Erro ao enviar cadastro. Tente novamente.', 'erro');
            } finally {
                // Restaurar botão
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        });
    }
    
    // Função para mostrar mensagens
    function mostrarMensagem(texto, tipo) {
        const mensagemDiv = document.getElementById('mensagem');
        mensagemDiv.textContent = texto;
        mensagemDiv.className = `mensagem ${tipo}`;
        
        // Ocultar mensagem após 5 segundos
        setTimeout(() => {
            mensagemDiv.style.display = 'none';
        }, 5000);
    }
    
    // Função para verificar se o formulário está na página
    function verificarFormulario() {
        if (!document.getElementById('cadastroForm')) {
            console.log("Formulário de cadastro não encontrado nesta página.");
        } else {
            console.log("Formulário de cadastro pronto para uso.");
        }
    }
    
    verificarFormulario();
});

// Para testar conexão
console.log("Firebase configurado com sucesso!");