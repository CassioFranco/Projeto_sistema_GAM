# 🧾 Sistema de Gestão de Ativos (Laravel)

Sistema desenvolvido em **Laravel** para gerenciamento e transferência de ativos entre colaboradores, com autenticação via **Sanctum** e testes automatizados com **PHPUnit**.

---

## 🚀 Tecnologias
- Laravel 10  
- PHP 8+  
- MySQL  
- Sanctum  
- PHPUnit  

---

## ⚙️ Instalação
```bash
git clone https://github.com/seu-usuario/sistema-ativos.git
cd sistema-ativos
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

---

## 🔐 Rotas Principais

| Método | Rota | Descrição | Auth |
|--------|------|------------|------|
| POST | /register | Registro de usuário | ❌ |
| POST | /login | Login e token | ❌ |
| POST | /logout | Logout | ✅ |
| POST | /ativos | Criação de ativo | ✅ |
| POST | /transferencia | Transferência de ativos | ✅ |
| GET | /relatorios | Relatórios gerais | ✅ |

---

## 🧪 Testes

**Executar testes:**
```bash
php artisan test
```

### ✅ Resultados
```
PASS  Tests\Unit\AssetTest
PASS  Tests\Unit\UserTest
PASS  Tests\Unit\AuditLogTest
PASS  Tests\Feature\CollaboratorTest
PASS  Tests\Feature\TransferTest
Tests: 7 passed (10 assertions)
```

### Tipos de Teste
- **Unitários:** 7  
- **Integração:** 4  
- **Sistema (documentado):** Registro → Login → Criar Ativos → Transferência → Relatório → Logout  
- **Usuário (documentado):** Teste de erro no registro com campos obrigatórios vazios  

---

## 🧩 Exemplos de Requisição

### Registro
```json
{
  "name": "João Silva",
  "email": "joao@example.com",
  "password": "123456",
  "idade": 30,
  "latitude": "-15.78",
  "longitude": "-47.92"
}
```

### Login
```json
{
  "email": "joao@example.com",
  "password": "123456"
}
```

### Transferência
```json
{
  "from_user_id": 1,
  "to_user_id": 2,
  "from_assets": [1],
  "to_assets": [2]
}
---

📚 **Disciplinas:** Desenvolvimento Web e Qualidade de Software
📅 **Ano:** 2025
