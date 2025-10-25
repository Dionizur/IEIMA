<?php
session_start();
include "./config/conexao.php"; // conexão MySQL

if(isset($_POST['cadastrar'])) {
    $usuario = mysqli_real_escape_string($conexao, $_POST['usuario']);
    $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
    $email = mysqli_real_escape_string($conexao, $_POST['email']);
    $telefone = mysqli_real_escape_string($conexao, $_POST['telefone']);
    $idade = mysqli_real_escape_string($conexao, $_POST['idade']);
    $aniversario = mysqli_real_escape_string($conexao, $_POST['aniversario']);
    $senha = $_POST['senha'];
    $senhaConfirm = $_POST['senha_confirm'];

    if($senha !== $senhaConfirm){
        $erro = "As senhas não coincidem!";
    } else {
        // Verifica se o usuário ou email já existe
        $query = mysqli_query($conexao, "SELECT * FROM usuarios WHERE usuario='$usuario' OR email='$email'");
        if(mysqli_num_rows($query) > 0){
            $erro = "Usuário ou email já cadastrado!";
        } else {
            // Criptografa a senha
            $hash = password_hash($senha, PASSWORD_DEFAULT);
            
            // Insere no banco com todos os campos da tabela
            $sql = "INSERT INTO usuarios (usuario, senha, nome, idade, aniversario, email, telefone) 
                    VALUES ('$usuario', '$hash', '$nome', '$idade', '$aniversario', '$email', '$telefone')";
            
            if(mysqli_query($conexao, $sql)) {
                $_SESSION['usuario'] = $usuario;
                header("Location:/pages/home.php"); // redireciona após cadastro
                exit;
            } else {
                $erro = "Erro ao cadastrar: " . mysqli_error($conexao);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro - Irmãos Menonitas</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.0/dist/tailwind.min.css" rel="stylesheet">
  <style>
    .form-container {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
    }
    
    .input-focus:focus {
      box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
      border-color: #3b82f6;
    }
    
    .btn-primary {
      background: linear-gradient(135deg, #1e40af, #3b82f6);
      transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
      background: linear-gradient(135deg, #1e3a8a, #2563eb);
      transform: translateY(-2px);
      box-shadow: 0 10px 20px rgba(30, 64, 175, 0.3);
    }
    
    .floating-label {
      transition: all 0.3s ease;
    }
    
    .input-filled + .floating-label,
    .input-field:focus + .floating-label {
      top: -10px;
      left: 10px;
      font-size: 0.75rem;
      background: white;
      padding: 0 5px;
      color: #3b82f6;
    }
  </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-50">

  <!-- Header -->
  <header class="bg-white shadow-sm border-b border-gray-100 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-20">
        <!-- Logo -->
        <a href="index.php" class="flex items-center space-x-3">
          <div class="w-12 h-12 bg-gradient-to-r from-blue-600 to-blue-800 rounded-full flex items-center justify-center shadow-lg">
            <svg class="w-7 h-7 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16z" clip-rule="evenodd" />
            </svg>
          </div>
          <div class="hidden sm:block">
            <h1 class="text-2xl font-bold text-gray-900">Irmãos Menonitas</h1>
            <p class="text-sm text-blue-600 font-medium">Ágape</p>
          </div>
        </a>
  </header>

  <!-- Hero Section -->
  <section class="relative bg-gradient-to-br from-blue-50 via-white to-blue-50 overflow-hidden py-12">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_40%,rgba(59,130,246,0.1),transparent_50%)]"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <div class="text-center mb-12">
        <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
          Faça Parte da Nossa <span class="text-blue-600">Comunidade</span>
        </h1>
        <p class="text-xl text-gray-600 max-w-2xl mx-auto">
          Junte-se à família da Igreja Ágape e cresça na fé conosco
        </p>
      </div>
    </div>
  </section>

  <!-- Cadastro Section -->
  <section class="py-12 bg-white">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="form-container rounded-3xl shadow-2xl p-8 md:p-12 border border-gray-100">
        <?php if(isset($erro)): ?>
          <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <?php echo $erro; ?>
          </div>
        <?php endif; ?>

        <form method="post" class="space-y-8">
          <!-- Informações Pessoais -->
          <div class="space-y-6">
            <h2 class="text-2xl font-bold text-gray-900 border-l-4 border-blue-600 pl-4">Informações Pessoais</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Nome Completo -->
              <div class="relative">
                <input 
                  type="text" 
                  id="nome" 
                  name="nome"
                  class="w-full px-4 py-3 border border-gray-300 rounded-xl input-focus input-field transition-all duration-300"
                  required
                  value="<?php echo isset($_POST['nome']) ? $_POST['nome'] : ''; ?>"
                >
                <label for="nome" class="floating-label absolute left-4 top-3 text-gray-500 pointer-events-none">Nome Completo *</label>
              </div>
              
              <!-- Idade -->
              <div class="relative">
                <input 
                  type="number" 
                  id="idade" 
                  name="idade"
                  min="1"
                  max="120"
                  class="w-full px-4 py-3 border border-gray-300 rounded-xl input-focus input-field transition-all duration-300"
                  value="<?php echo isset($_POST['idade']) ? $_POST['idade'] : ''; ?>"
                >
                <label for="idade" class="floating-label absolute left-4 top-3 text-gray-500 pointer-events-none">Idade</label>
              </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Data de Nascimento -->
              <div class="relative">
                <input 
                  type="date" 
                  id="aniversario" 
                  name="aniversario"
                  class="w-full px-4 py-3 border border-gray-300 rounded-xl input-focus input-field transition-all duration-300"
                  value="<?php echo isset($_POST['aniversario']) ? $_POST['aniversario'] : ''; ?>"
                >
                <label for="aniversario" class="floating-label absolute left-4 top-3 text-gray-500 pointer-events-none">Data de Nascimento</label>
              </div>

              <!-- Telefone -->
              <div class="relative">
                <input 
                  type="tel" 
                  id="telefone" 
                  name="telefone"
                  class="w-full px-4 py-3 border border-gray-300 rounded-xl input-focus input-field transition-all duration-300"
                  value="<?php echo isset($_POST['telefone']) ? $_POST['telefone'] : ''; ?>"
                >
                <label for="telefone" class="floating-label absolute left-4 top-3 text-gray-500 pointer-events-none">Telefone</label>
              </div>
            </div>
            
            <!-- Email -->
            <div class="relative">
              <input 
                type="email" 
                id="email" 
                name="email"
                class="w-full px-4 py-3 border border-gray-300 rounded-xl input-focus input-field transition-all duration-300"
                required
                value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>"
              >
              <label for="email" class="floating-label absolute left-4 top-3 text-gray-500 pointer-events-none">Email *</label>
            </div>
          </div>

          <!-- Dados de Acesso -->
          <div class="space-y-6">
            <h2 class="text-2xl font-bold text-gray-900 border-l-4 border-blue-600 pl-4">Dados de Acesso</h2>
            
            <!-- Nome de Usuário -->
            <div class="relative">
              <input 
                type="text" 
                id="usuario" 
                name="usuario"
                class="w-full px-4 py-3 border border-gray-300 rounded-xl input-focus input-field transition-all duration-300"
                required
                value="<?php echo isset($_POST['usuario']) ? $_POST['usuario'] : ''; ?>"
              >
              <label for="usuario" class="floating-label absolute left-4 top-3 text-gray-500 pointer-events-none">Nome de Usuário *</label>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Senha -->
              <div class="relative">
                <input 
                  type="password" 
                  id="senha" 
                  name="senha"
                  class="w-full px-4 py-3 border border-gray-300 rounded-xl input-focus input-field transition-all duration-300"
                  required
                >
                <label for="senha" class="floating-label absolute left-4 top-3 text-gray-500 pointer-events-none">Senha *</label>
              </div>
              
              <!-- Confirmar Senha -->
              <div class="relative">
                <input 
                  type="password" 
                  id="senha_confirm" 
                  name="senha_confirm"
                  class="w-full px-4 py-3 border border-gray-300 rounded-xl input-focus input-field transition-all duration-300"
                  required
                >
                <label for="senha_confirm" class="floating-label absolute left-4 top-3 text-gray-500 pointer-events-none">Confirmar Senha *</label>
              </div>
            </div>
          </div>

          <!-- Termos e Condições -->
          <div class="flex items-start space-x-3">
            <input 
              type="checkbox" 
              id="termos" 
              name="termos"
              class="mt-1 w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
              required
            >
            <label for="termos" class="text-sm text-gray-600">
              Concordo com os <a href="#" class="text-blue-600 hover:underline">termos e condições</a> e 
              <a href="#" class="text-blue-600 hover:underline">política de privacidade</a> *
            </label>
          </div>

          <!-- Botões de Ação -->
          <div class="flex flex-col sm:flex-row gap-4 pt-6">
            <button 
              type="submit" 
              name="cadastrar"
              class="flex-1 btn-primary text-white px-8 py-4 text-lg font-semibold rounded-xl shadow-lg"
            >
              Criar Conta
              <svg class="ml-2 h-5 w-5 inline" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
              </svg>
            </button>
            
            <a href="login.php" class="flex-1 border border-blue-600 text-blue-600 hover:bg-blue-50 px-8 py-4 text-lg font-semibold rounded-xl text-center transition-colors">
              Já tenho uma conta
            </a>
          </div>
        </form>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-gray-900 text-white mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
        <!-- Igreja Info -->
        <div class="space-y-4">
          <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-blue-700 rounded-full flex items-center justify-center">
              <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16z" clip-rule="evenodd" />
              </svg>
            </div>
            <div>
              <h3 class="text-xl font-bold">Irmãos Menonitas</h3>
              <p class="text-blue-400">Ágape</p>
            </div>
          </div>
          <p class="text-gray-300 leading-relaxed">
            Uma comunidade de fé dedicada ao amor de Cristo e ao serviço ao próximo, localizada na Fazenda Rio Grande.
          </p>
        </div>

        <!-- Contato -->
        <div class="space-y-4">
          <h3 class="text-xl font-semibold">Contato</h3>
          <div class="space-y-3">
            <div class="flex items-center space-x-3">
              <svg class="w-5 h-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16z" clip-rule="evenodd" />
              </svg>
              <span class="text-gray-300">Fazenda Rio Grande</span>
            </div>
            <div class="flex items-center space-x-3">
              <svg class="w-5 h-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16z" clip-rule="evenodd" />
              </svg>
              <span class="text-gray-300">(41) 99999-9999</span>
            </div>
            <div class="flex items-center space-x-3">
              <svg class="w-5 h-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16z" clip-rule="evenodd" />
              </svg>
              <span class="text-gray-300">contato@menonitasagape.com.br</span>
            </div>
          </div>
        </div>

        <!-- Horários -->
        <div class="space-y-4">
          <h3 class="text-xl font-semibold">Nossos Encontros</h3>
          <div class="space-y-2 text-gray-300">
            <p><strong class="text-white">Culto Principal:</strong> Domingos às 9h</p>
            <p><strong class="text-white">Estudo Bíblico:</strong> Quartas às 19h30</p>
            <p><strong class="text-white">Jovens:</strong> Sábados às 19h</p>
            <p><strong class="text-white">Crianças:</strong> Domingos às 9h</p>
          </div>
        </div>
      </div>

      <div class="border-t border-gray-700 mt-12 pt-8 text-center">
        <p class="text-gray-400">
          © 2024 Igreja Irmãos Menonitas Ágape. Todos os direitos reservados.
        </p>
      </div>
    </div>
  </footer>

  <script>
    // Mobile Menu Toggle
    document.getElementById('mobile-menu-button').addEventListener('click', function() {
      const mobileNav = document.getElementById('mobile-nav');
      mobileNav.style.display = mobileNav.style.display === 'none' ? 'block' : 'none';
    });

    // Floating Labels
    document.querySelectorAll('.input-field').forEach(input => {
      // Check if field has value on page load
      if (input.value) {
        input.classList.add('input-filled');
      }
      
      input.addEventListener('focus', function() {
        this.classList.add('input-filled');
      });
      
      input.addEventListener('blur', function() {
        if (!this.value) {
          this.classList.remove('input-filled');
        }
      });
    });

    // Form Validation
    document.querySelector('form').addEventListener('submit', function(e) {
      const senha = document.getElementById('senha').value;
      const confirmarSenha = document.getElementById('senha_confirm').value;
      
      if (senha !== confirmarSenha) {
        e.preventDefault();
        alert('As senhas não coincidem!');
        return;
      }
      
      if (!document.getElementById('termos').checked) {
        e.preventDefault();
        alert('Você deve aceitar os termos e condições!');
        return;
      }
    });
  </script>

</body>
</html>