document.addEventListener("DOMContentLoaded", function () {
    const loginButton = document.getElementById("login-button");
    const logoutButton = document.getElementById("logout-button");
    const userMenu = document.getElementById("user-menu");
    const mobileMenuButton = document.getElementById("mobile-menu-button");
    const mobileNav = document.getElementById("mobile-nav");
    const mobileUser = document.getElementById("mobile-user");
  
    // Mock user data for demonstration purposes
    let user = null;
  
    const checkAuth = () => {
      // Simulate authentication check
      setTimeout(() => {
        user = {
          full_name: "João Silva",
          email: "joao@exemplo.com",
        };
        updateUserMenu();
      }, 1000);
    };
  
    const updateUserMenu = () => {
      if (user) {
        loginButton.style.display = "none";
        logoutButton.style.display = "block";
  
        userMenu.innerHTML = `
          <span class="text-sm text-gray-700">${user.full_name || 'Usuário'}</span>
        `;
  
        mobileUser.innerHTML = `
          <div class="px-4 py-2">
            <p class="font-medium text-gray-900">${user.full_name || 'Usuário'}</p>
            <p class="text-sm text-gray-500">${user.email}</p>
          </div>
          <button id="logout-button-mobile" class="w-full justify-start text-red-600 hover:bg-red-50">Sair</button>
        `;
  
        document.getElementById("logout-button-mobile").addEventListener("click", () => {
          user = null;
          updateUserMenu();
        });
      } else {
        loginButton.style.display = "block";
        logoutButton.style.display = "none";
      }
    };
  
    loginButton.addEventListener("click", () => {
      // Simulate login
      user = { full_name: "João Silva", email: "joao@exemplo.com" };
      updateUserMenu();
    });
  
    logoutButton.addEventListener("click", () => {
      // Simulate logout
      user = null;
      updateUserMenu();
    });
  
    mobileMenuButton.addEventListener("click", () => {
      mobileNav.style.display = mobileNav.style.display === "none" ? "block" : "none";
    });
  
    checkAuth();
  });
  