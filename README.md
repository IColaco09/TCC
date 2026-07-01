# Sistema Gerencial — TCC

Sistema web de gestão empresarial desenvolvido em PHP com arquitetura MVC, voltado para o controle de clientes, produtos, pedidos, vendas e usuários.

---

## Tecnologias

- **PHP** — Backend e roteamento
- **MySQL** — Banco de dados
- **HTML/CSS** — Interface
- **JavaScript** — Interações no frontend
- **Apache** — Servidor web (via XAMPP)

---

## Estrutura do Projeto

```
TCC/
├── app/
│   ├── Controller/
│   │   ├── ControllerHome.php
│   │   ├── ControllerLogin.php
│   │   ├── ControllerUsuarios.php
│   │   ├── ControllerClientes.php
│   │   ├── ControllerProdutos.php
│   │   ├── ControllerVendas.php
│   │   ├── ControllerPedidos.php
│   │   └── ControllerRelatorios.php
│   ├── Model/
│   │   ├── ModelHome.php
│   │   ├── ModelLogin.php
│   │   ├── ModelUsuarios.php
│   │   ├── ModelClientes.php
│   │   ├── ModelProdutos.php
│   │   ├── ModelVendas.php
│   │   ├── ModelPedido.php
│   │   └── ModelRelatorios.php
│   └── View/
│       ├── Home/
│       ├── Login/
│       ├── Usuarios/
│       ├── Clientes/
│       ├── Produtos/
│       ├── Vendas/
│       └── Pedidos/
├── config/
│   ├── Auth.php
│   └── modelbase/
│       └── conexao.php
├── public/
│   ├── Assets/
│   │   ├── css/
│   │   │   ├── Login.css
│   │   │   └── Home.css
│   │   └── js/
│   │       └── rotas.js
│   └── index.php
└── .htaccess
```

---

## Como rodar o projeto

### Pré-requisitos
- [XAMPP](https://www.apachefriends.org/) instalado
- PHP 8.0 ou superior
- MySQL

### Passo a passo

**1. Clone o repositório**
```bash
git clone https://github.com/IColaco09/TCC.git
```

**2. Mova para a pasta do XAMPP**
```
C:/xampp/htdocs/TCC
```

**3. Crie o banco de dados**

Acesse o phpMyAdmin (`http://localhost/phpmyadmin`) e crie um banco chamado `sistemacbs`, depois execute o SQL abaixo:

```sql
CREATE DATABASE IF NOT EXISTS `tcc_provisorio` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `tcc_provisorio`;

-- --------------------------------------------------------
-- Tabela: categorias
-- --------------------------------------------------------
CREATE TABLE `categorias` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `descricao` text DEFAULT NULL,
  `criado_em` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome` (`nome`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Tabela: clientes
-- --------------------------------------------------------
CREATE TABLE `clientes` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) NOT NULL,
  `cpf_cnpj` varchar(20) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  `cidade` varchar(100) DEFAULT NULL,
  `estado` char(2) DEFAULT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `criado_em` datetime NOT NULL DEFAULT current_timestamp(),
  `atualizado_em` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `cpf_cnpj` (`cpf_cnpj`),
  KEY `idx_clientes_nome` (`nome`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Tabela: historico
-- --------------------------------------------------------
CREATE TABLE `historico` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `usuario_id` int(10) UNSIGNED DEFAULT NULL,
  `tabela` varchar(50) NOT NULL,
  `registro_id` int(10) UNSIGNED NOT NULL,
  `acao` enum('criacao','edicao','exclusao','status') NOT NULL,
  `descricao` text DEFAULT NULL,
  `criado_em` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_hist_usuario` (`usuario_id`),
  KEY `idx_historico_tabela` (`tabela`,`registro_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Tabela: pedidos
-- --------------------------------------------------------
CREATE TABLE `pedidos` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cliente_id` int(10) UNSIGNED NOT NULL,
  `usuario_id` int(10) UNSIGNED NOT NULL,
  `status` enum('aberto','em_andamento','concluido','cancelado') NOT NULL DEFAULT 'aberto',
  `observacoes` text DEFAULT NULL,
  `total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `criado_em` datetime NOT NULL DEFAULT current_timestamp(),
  `atualizado_em` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_ped_usuario` (`usuario_id`),
  KEY `idx_pedidos_cliente` (`cliente_id`),
  KEY `idx_pedidos_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Tabela: pedido_itens
-- --------------------------------------------------------
CREATE TABLE `pedido_itens` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pedido_id` int(10) UNSIGNED NOT NULL,
  `produto_id` int(10) UNSIGNED NOT NULL,
  `quantidade` int(11) NOT NULL DEFAULT 1,
  `preco_unit` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) GENERATED ALWAYS AS (`quantidade` * `preco_unit`) STORED,
  PRIMARY KEY (`id`),
  KEY `fk_item_pedido` (`pedido_id`),
  KEY `fk_item_produto` (`produto_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Tabela: produtos
-- --------------------------------------------------------
CREATE TABLE `produtos` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `categoria_id` int(10) UNSIGNED DEFAULT NULL,
  `codigo` varchar(50) DEFAULT NULL,
  `nome` varchar(150) NOT NULL,
  `descricao` text DEFAULT NULL,
  `tipo` enum('produto','servico') NOT NULL DEFAULT 'produto',
  `preco` decimal(10,2) NOT NULL DEFAULT 0.00,
  `estoque` int(11) NOT NULL DEFAULT 0,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `criado_em` datetime NOT NULL DEFAULT current_timestamp(),
  `atualizado_em` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `codigo` (`codigo`),
  KEY `fk_prod_categoria` (`categoria_id`),
  KEY `idx_produtos_nome` (`nome`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Tabela: usuarios
-- --------------------------------------------------------
CREATE TABLE `usuarios` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `tipo_usuario` int(11) NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `criado_em` datetime NOT NULL DEFAULT current_timestamp(),
  `atualizado_em` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Chaves estrangeiras
-- --------------------------------------------------------
ALTER TABLE `historico`
  ADD CONSTRAINT `fk_hist_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL;

ALTER TABLE `pedidos`
  ADD CONSTRAINT `fk_ped_cliente` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`),
  ADD CONSTRAINT `fk_ped_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

ALTER TABLE `pedido_itens`
  ADD CONSTRAINT `fk_item_pedido` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_item_produto` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`);

ALTER TABLE `produtos`
  ADD CONSTRAINT `fk_prod_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE SET NULL;

-- --------------------------------------------------------
-- Inserção perfil de admin
-- --------------------------------------------------------
INSERT INTO `usuarios` (`nome`, `email`, `senha`, `tipo_usuario`, `ativo`) VALUES
('Admin', 'admin@tcc.local', '$2y$10$bIuceYW5HhQjgBXTLBLyaOCs0JmCMAiDlftZgnsHxKTqtaizQ559e', 1, 1);
-- Copie até aqui !!!

Email: admin@tcc.local
Senha em Hash: '$2y$10$bIuceYW5HhQjgBXTLBLyaOCs0JmCMAiDlftZgnsHxKTqtaizQ559e'
--Em caso de mal funcionamento entrar em contato com Dev Responsavel


**5. Acesse o sistema**
```
http://localhost/TCC/?url=login
```

---

## Perfis de Usuário

| Código | Perfil |
|--------|--------|
| 1 | Admin |
| 2 | Gerente |
| 3 | Usuário |

---

## Funcionalidades

- [x] Login com autenticação segura (`password_hash` / `password_verify`)
- [x] Dashboard com resumo de clientes, produtos e vendas
- [x] Gestão de Usuários (listar, cadastrar, editar, excluir)
- [X] Gestão de Clientes
- [X] Gestão de Produtos
- [ ] Gestão de Pedidos
- [ ] Relatórios

---

## Segurança

- Senhas armazenadas com `password_hash()`
- Sessões com `cookie_httponly` e `use_only_cookies`
- `session_regenerate_id()` no login
- Proteção contra SQL Injection via `prepared statements`
- Sanitização de output com `htmlspecialchars()`

---

## Autor

Desenvolvido por **IColaco09, Natan58, Caio-Guerra, Henzo Malta(Gullit96) entre outros** como projeto de TCC.
