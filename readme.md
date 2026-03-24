# I Gallery

### Descrição

Plugin do WordPress para galeria com paginação. As imagens são carregadas após a página terminar de carregar.

### Pacotes

Para instalar em um ambiente de desenvolvimento, navegue até o diretório `/src`, instale o gerenciador de pacotes do Node.js e os seguintes pacotes:

- npm `npm install`
- grunt `npm install grunt`
- node-sass `npm install node-sass grunt-sass`

##### Obs: também é necessário renomear o nome do diretório do plugin, o nome do arquivo principal .php do plugin, o(s) nome(s) do(s) arquivo(s) .js e do(s) arquivo(s) .scss

### Grunt

Estas são as tasks utilizadas:

- `grunt`: task default - gera a versão minificada dos arquivos **.css** e **.js**
- `grunt o`: otimiza as imagens
- `grunt c`: executa as task anteriores e gera um arquivo **.zip** no diretório `/dist` (este será o arquivo usado para atualizar o plugin no Wordpress)
- `grunt w`: executa o `livereload.js` - já vem com um array de IPs para funcionar apenas em ambiente de desenvolvimento (adicione o seu IP no array, caso necessário)

### Includes

Neste modelo de plugin, já vem incluso as seguintes bibliotecas/módulos

- [WP Update Server](https://github.com/YahnisElsts/wp-update-server): API que verifica e aplica atualizações do I Gallery, através do próprio sistema de atualizações do WordPress
- `class-post-type.php`: classe para a criação de **Custom Post Type**
- `class-taxonomy.php`: classe para a criação de **Custom Taxonomy**

### Referências

Parte do código usado neste plugin foi retirado do [Odin Framework](https://github.com/wpbrasil/odin), o melhor tema-base de desenvolvimento para WordPress, desenvolvido e mantido pelo [WordPress Brasil](https://www.facebook.com/groups/wordpress.brasil).
