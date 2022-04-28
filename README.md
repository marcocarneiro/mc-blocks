# MC Blocks
Coleção de Blocos de Gutenberg - WordPress<br>
Para temas construídos com o Bootstrap 5.<br>
A justificativa para esse conjunto de blocos é para temas WordPress que não utilizam construtores de páginas como o Elementor ou o DIVI. Usuários com pouca experiência em ferramentas de Design Gráfico sentem dificuldade com esses construtores de páginas, para esses casos os blocos são uma opção "mais confortável" para a edição.<br>
MC Blocks utiliza a biblioteca <a href="https://carbonfields.net/" target="_blank">Carbon Fields,</a> que permite o desenvolvimento de blocos totalmente feitos com código PHP. Utilize como um complemento do plugin Kadence Blocks. A montagem de layouts fica muito fácil utilizando o sistema de GRID do Kadence Blocks que permite a inserção de blocos MC Blocks.

## Blocos disponíveis

### Imagem videomodal
Esse bloco abre um vídeo incorporado (vimeo ou youtube) dentro de um modal.
Uma imagem servirá de link para a abertura do vídeo

### Vídeo Background
Bloco que adiciona um vídeo com a largura total da página como de fundo na página.
Pode-se incluir uma legenda sobre o vídeo. O arquivo deverá estar na biblioteca de mídias, o bloco não funciona para vídeos incorporados do Vimeo ou Youtube.

### Slideshow
Bloco baseado no componente Carousel do Bootstrap. Pode-se inserir várias imagens com ou sem legendas.

### Simulação Financiamento
Esse bloco pode ser usado em sites de financeiras ou cooperativas de crédito, serve para o usuário fazer uma simulação de financiamento. Nas configurações do bloco pode-se definir uma taxa de juros e quantidade máximas de parcelas, o bloco calcula o valor da mensalidade após o usuário digitar um valor e parcelas desejadas.

### Colunas Simples
Esse bloco permite a adição de colunas bootstrap. Dentro das colunas pode-se configurar cor de fundo, padding e animação de entrada.
O conteúdo das colunas é definido com um bloco de Rich Text.

### Lista de Bullets Coloridos
Bloco onde o administrador / editor insere uma lista onde poderá escolher a cor e tamanho do marcador.

### Accordion Simples
Link, botão ou imagem para revelar um conteúdo de Rich Text.

### Image Accordion
Bloco onde uma imagem abre um accordion no centro da imagem. Deve-se ter uma imagem como cabeçalho e outra para rodapé, o conteúdo é aberto no centro. <a href="https://cooperata.coop.br/cooperativismo/" target="_blank">Veja o exemplo aqui</a> 

### Open Modal
Bloco onde uma imagem ou texto abre um determinado modal na página. Pode-se inserir quantos modais desejar.

### Gerador de PDF
Bloco onde o administrador / Editor do site poderá montar uma estrutura de parágrafos e campos de formulário onde o usuário do site poderá ao final do preenchimento, gerar um PDF com os campos preenchidos.<br>
Utiliza a biblioteca <a href="https://github.com/dompdf/dompdf" target="_blank">DomPDF,</a> previamente instalado com o composer juntamente com o plugin.
