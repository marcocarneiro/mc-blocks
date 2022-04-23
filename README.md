# mc-blocks
Coleção de Blocos de Gutenberg - WordPress<br>
Para temas qu utilizam o Bootstrap 5.<br>
Essa coleção de blocos utiliza a biblioteca <a href="https://carbonfields.net/" target="_blank">Carbon Fields,</a> blocos totalmente feitos com código PHP.

## Blocos disponíveis

### Imagem videomodal
Esse bloco abre um vídeo incorporado (vimeo ou youtube) dentro de um modal.
Uma imagem servirá de link para a abertura do vídeo

### Vídeo Background
Bloco que adiciona um vídeo com a largura total da página como de fundo na página.
Pode-se incluir uma legenda sobre o vídeo. O arquivo deverá estar na biblioteca de mídias, o bloco não funciona para vídeos incorporados como Vimeo ou Youtube.

### Slideshow
Bloco baseado no componente Carousel do Bootstrap. Pode-se inserir várias imagens com ou sem legendas.

### Simulação Financiamento
Esse bloco pode ser usado em sites de financeiras ou cooperativas de crédito, serve para o usuário fazer uma simulação de financiamento. Nas configurações do bloco pode-se definir uma taxa de juros e quantidade máximas de parcelas, o bloco calcula o valor da mensalidade após o usuário digitar um valor e parcelas desejadas.

### Accordion Simples
Link ou botão para revelar um conteúdo de texto ou imagem. 

### Image Accordion
Bloco onde uma imagem abre um accordion no centro da imagem. Deve-se ter uma imagem como cabeçalho e outra para rodapé, o conteúdo é aberto no centro. <a href="https://cooperata.coop.br/cooperativismo/" target="_blank">Veja o exemplo aqui</a> 

### Open Modal
Bloco onde uma imagem ou texto abre um determinado modal na página. Pode-se inserir quantos modais quiser.

### Gerador de PDF
Bloco onde o administrador / Editor do site poderá montar uma estrutura de parágrafos e campos de formulário onde o usuário do site poderá ao final do preenchimento, gerar um PDF com os campos preenchidos.<br>
Utiliza o <a href="https://github.com/dompdf/dompdf" target="_blank">DomPDF,</a> previamente instalado com o composer juntamente com o plugin.
