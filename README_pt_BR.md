# UltraCMS

Simples gerenciador CMS/Framework

[Veja esse LEAIME em en_US](https://github.com/in9web/ultracms/blob/master/README.md) ![en_US Flag](http://findicons.com/files/icons/282/flags/16/united_states_of_america.png)

# Preview do tema "default"/padrao
Este tema funcionando com tradução em pt_BR (portugues)
![UltraCMS theme default preview](https://i.imgur.com/PtUxHxk.jpg)

# Funcionalidades

- Whitelabel/“marca branca” - Copie o sistema e coloque o nome que desejar;
- Criações em linha de comando;
- Liberdade para criar front-end como desejar;
- Criar de admin similar ao Cake Bake (CakePHP) ou Scafolding (Ruby on Rails);
- Admin Modular;
- Suporte para migrações no banco de dados;
- Temas no Admin;
- Autenticação no Admin;
- Configuravel com .env, mude tudo sem problemas;
  - Ambiente não obrigatório, mude .env e 'voulá';
- Suporte a logs;
- Traduções;
- Código aberto;

# Instalação

No futuro vamos add ao packagist(composer), Por agora, clone este repositorio com:

```git clone https://github.com/in9web/ultracms.git```

depois de clonado instale as dependencias com o composer assim:

```composer install```

depois disso vou pode mudar as configurações e executar os comandos básicos para criar seu primeiro modulo como:

```./ultra make:module Pages``` isso vai criar uma pasta no seu admin com o crud básico para o model de sua "Page"

# Configuração

Você pode mudar o arquivo ```.env``` em sua pasta ou mudar ```config.php``` em sua pasta para adicionar mais configurações.
Lembre-se este CMS é whitelabel e você pode mudar no arquivo ```config.php```.

# Documentação

## Vamos começar

## Tutoriais

## API

# Contruibuir

Agradecemos por sua consideração em contribuir para o UltraCMS.
Você tem algo a reportar, abra uma issue em https://github.com/in9web/ultracms/issues

# Log de alterações

0.1.0 - Beta Version Released, basic usage. Upload file not working.

# Tarefas/Lista do que fazer

- Criar uma logo para o UltraCMS;
- Adicionar suporte para upload de arquivos;
- Adicionar comandos para remover modulo;
- Criar documentação para o "Vamos começar"/GetStarted;
- Criar video tutorial de como usar UltraCMS em pt_BR e depois em en_US;
- Adicionar assets para o Colorbox;
- Criar tema para o admin usando AdminLTE;
- Criar funcionalidade de widgets para os modules, para uso externo do modulo;
- Adicionar suporte para API requests usando PHPCrudAPI (https://github.com/mevdschee/php-crud-api)
- Adicionar melhor suporte a logs;
- Adicionar melhor suporte a migrações nos modulos;
- Adicionar melhor suporte a Models nos modulos;
- Adicionar tradução do core para Espanhol;

# Licença

Este trabalho é licenciado sobre a [MIT License](https://github.com/in9web/ultracms/blob/master/LICENSE)
