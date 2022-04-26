<?php
/*
Plugin Name: MC Blocks
Text Domain: mc-blocks
*/

use Carbon_Fields\Block;
use Carbon_Fields\Field;
use Carbon_Fields\Container;

 
defined( 'ABSPATH' ) || exit;


function mc_blocks_load() {
	require_once( 'vendor/autoload.php' );
	\Carbon_Fields\Carbon_Fields::boot();
}
add_action( 'after_setup_theme', 'mc_blocks_load' );

//Função geradora de SLUGS para utilizar em atributos ID
function slugify($text)
{
  // replace non letter or digits by -
  $text = preg_replace('~[^\pL\d]+~u', '-', $text);
  // transliterate
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
  // remove unwanted characters
  $text = preg_replace('~[^-\w]+~', '', $text);
  // trim
  $text = trim($text, '-');
  // remove duplicate -
  $text = preg_replace('~-+~', '-', $text);
  // lowercase
  $text = strtolower($text);
  if (empty($text)) {
    return 'n-a';
  }
  return $text;
}


/**
 * Bloco Imagem videomodal
 */
function imagem_videomodal()
{
	Block::make( 'MC vídeo modal' )
		->add_fields( array(
			Field::make( 'text', 'incorporacao', __( 'Código de incorporação (Youtube ou Vimeo)' ) ),
			Field::make( 'image', 'image', __( 'Imagem primeiro frame' ) ),
		) )
		->set_description( __( 'Bloco de imagem que abre um vídeo num modal.' ) )
		->set_category( 'custom-category', __( 'MC Blocks' ), 'smiley' )
		->set_icon( 'media-video' )
		->set_render_callback( function ( $block ) {
 
			ob_start();
			?>
			
			<figure class="mcblocks-videomodal wp-block-image size-full clickable" 
			onclick="abreModal('<?php echo esc_html( $block['incorporacao'] ); ?>')">
				<?php echo wp_get_attachment_image( $block['image'], 'full' ); ?>
			</figure>					
 
			<?php
 
			return ob_get_flush();
		} );
}
add_action( 'carbon_fields_register_fields', 'imagem_videomodal' );



/**
 * Bloco Vídeo Background
 */
function video_background()
{
	Block::make( 'MC Vídeo Background' )
		->add_fields( array(
			Field::make( 'image', 'url_video', __( 'Vídeo' ) )->set_type( array( 'image', 'video' ) ),
			Field::make( 'rich_text', 'content', __( 'Conteúdo' ) ),
		) )
		->set_description( __( 'Bloco para vídeo fullscreen formato mp4 - arquivo deverá estar na biblioteca.' ) )
		->set_category( 'custom-category', __( 'MC Blocks' ), 'smiley' )
		->set_icon( 'format-video' )
		->set_render_callback( function ( $block ) {
 
			ob_start();
				?>

				<?php 
					$url = wp_get_attachment_url( $block['url_video'] );
					$imgsrc = esc_html( $url );
				?>

				<div class="mcblocks-videofullscreen">
					<video src="<?php echo $imgsrc ?>" muted="" loop="" autoplay=""></video>
					<div class="content" data-aos="fade-right" data-aos-duration="1000" data-aos-delay="1000">
						<?php echo apply_filters( 'the_content', $block['content'] ); ?>
					</div>
				</div>

				<?php 
			return ob_get_flush();
	} );
}
add_action( 'carbon_fields_register_fields', 'video_background' );


/**
 * Bloco Simulação Financiamento
 */
function simulacao_financiamento()
{
	Block::make( 'Simulação Financiamento' )
		->add_fields( array(
			Field::make( 'text', 'titulo', 'Nome da linha de financiamento' ),
			Field::make( 'number', 'taxa', 'Taxa' ),
			Field::make( 'number', 'limite', 'Limite de parcelas' )
		) )
		->set_description( __( 'Bloco para permitir que os usuários façam uma simulação de financiamento.' ) )
		->set_category( 'custom-category', __( 'MC Blocks' ), 'smiley' )
		->set_icon( 'calculator' )
		->set_render_callback( function ( $block ) {
 
			ob_start();
			?>
				<form id="mcblocks-form-simulacao">
					<input class="form-control mb-5 inputVlr" id="mcblocks-valor" type="text" placeholder="Valor do Empréstimo">
					<input class="form-control parcelas" id="mcblocks-parcelas" onkeyup="simulacao()" type="text" placeholder="Parcelas">
				</form>
				<p class="text-white" id="mcblocks-txt-auxiliar"></p>
				<h1 id="mcblocks-txt-resultado"></h1>
				<script>					
					function calculaParcela(valor, parcelas, juros) 
					{						
						valor = (valor * 1.00033) * 1.0173;
						resultado = valor * ((Math.pow(1 + juros, parcelas) * juros) / (Math.pow(1 + juros, parcelas) - 1));
						return resultado;
					}
					function simulacao()
					{
						var vlr = Number(document.getElementById('mcblocks-valor').value);
						var parcelas = Number(document.getElementById('mcblocks-parcelas').value);
						if(parcelas > Number(<?php echo $block['limite'] ?>))
						{
							alert('O limite máximo de parcelas é ' + <?php echo $block['limite'] ?> );
							document.getElementById('mcblocks-parcelas').value = '';
						}
						var juros = Number(<?php echo $block['taxa'] ?>)*0.01;
						var result = calculaParcela(vlr, parcelas, juros);
						result = String(result.toFixed(2).replace(".", ","));
						document.getElementById('mcblocks-txt-resultado').innerText = result;
					}
				</script>
 
			<?php 
			return ob_get_flush();
		} );
}
add_action( 'carbon_fields_register_fields', 'simulacao_financiamento' );


/**
 * Bloco Slideshow
 */
function sliders()
{
    Block::make(__('MC Slider Show'))->add_fields(array(
        Field::make('text', 'titulo', __('Block Title')) ,
        Field::make('complex', 'coluna', __('Counter'))
            ->set_layout('tabbed-horizontal')
            ->add_fields(array(
            Field::make('image', 'counter_img', 'Imagem')
                ->set_required(true)
                ->set_value_type('url')
                ->set_width(50) ,
            Field::make('text', 'legenda', 'Legenda')
                ->set_width(30) ,

        )) ,

    ))
        ->set_icon('media-interactive')
        ->set_keywords([__('SliderShow') ])
        ->set_description(__('Bloco para criação de SlideShow baseado no componente carousel do Bootstrap.'))
		->set_category( 'custom-category', __( 'MC Blocks' ), 'smiley' )
        ->set_render_callback(function ($fields, $attributes, $inner_blocks)
    {

        //Cria um slug com o título do slideshow
		$id = slugify($fields['titulo']);

		$colunas = $fields['coluna'];
        if ($colunas):			
			echo '<div id="' .$id. '" class="carousel slide" data-bs-ride="carousel">';
			echo '<div class="carousel-indicators">';
				for ($c=0; $c < count($colunas); $c++) {
					if($c == 0){
						echo '<button type="button" data-bs-target="#' .$id. '" data-bs-slide-to="' .$c. '" class="active" aria-current="true" aria-label="Slide ' .$c. '"></button>';
					}else{
						echo '<button type="button" data-bs-target="#' .$id. '" data-bs-slide-to="' .$c. '" aria-label="Slide ' .$c. '"></button>';
					}					
				}
			echo '</div>';
			echo '<div class="carousel-inner">';

			$i = 0;
			foreach ($colunas as $counter):
                $image_black = $counter['counter_img'];
                $list_counter_tb = $counter['legenda'];
				
				if($i == 0)
				{ 
					echo '<div class="carousel-item active">';
				}else{
					echo '<div class="carousel-item ">';
				}				
				echo '	<img src="'.$counter['counter_img'].'" class="d-block w-100" alt="' .$counter['legenda']. '">';
				echo '	<div class="carousel-caption d-none d-md-block">';
				echo '		<p>' .$counter['legenda']. '</p>';
				echo '	</div>';
				echo '</div>';

				$i ++;
				
			endforeach;
			echo '</div>';

			echo '<button class="carousel-control-prev" type="button" data-bs-target="#' .$id. '" data-bs-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="visually-hidden">Previous</span>
			</button>
			<button class="carousel-control-next" type="button" data-bs-target="#' .$id. '" data-bs-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="visually-hidden">Next</span>
			</button>';

			echo '</div>';

        endif;
    });
}
add_action('carbon_fields_register_fields', 'sliders');


/**
 * Bloco Colunas Simples
 */
function colunas()
{
    Block::make(__('MC Colunas'))->add_fields(array(
        Field::make( 'color', 'bg_cor_linha', __( 'Cor de fundo para a linha de colunas' ) )
		->set_palette( array( '#FF0000', '#00FF00', '#0000FF' ) ),
        Field::make('complex', 'coluna', __('Inserir colunas'))
            ->set_layout('tabbed-horizontal')
            ->add_fields(array(
				//configuração de cada coluna
				Field::make( 'number', 'tamanho', 'Tamanho da coluna (1 a 12)' )->set_width(10),
				Field::make( 'color', 'bg_cor', __( 'Cor de fundo para a coluna' ) )->set_width(10),
				Field::make( 'select', 'animacao', __( 'Selecione uma animação para a coluna' ) )->set_width(10)
				->set_options( array(
					'nenhuma' => 'nenhuma',
					'fade-up' => 'fade-up',
					'fade-down' => 'fade-down',
					'fade-right' => 'fade-right',
					'fade-left' => 'fade-left',
					'flip-left' => 'flip-left',
					'flip-right' => 'flip-right',
					'flip-up' => 'flip-up',
					'flip-down' => 'flip-down',
					'zoom-in' => 'zoom-in',
				) ),
				Field::make( 'number', 'duracao', 'Duração da animação em milisegundos (1000 = 1 segundo)' )->set_width(10),
				Field::make( 'number', 'delay', 'Delay da animação em milisegundos (1000 = 1 segundo)' )->set_width(10),
				Field::make( 'number', 'padding', 'Margem interna - padding - 1 a 5' )->set_width(10),
				Field::make( 'rich_text', 'conteudo', __( 'Conteúdo' ) )
        )) ,

    ))
        ->set_icon('grid-view')
        ->set_keywords([__('Colunas') ])
        ->set_description(__('Bloco para criação de colunas Bootstrap - tela dividida em 12 colunas.'))
		->set_category( 'custom-category', __( 'MC Blocks' ), 'smiley' )
        ->set_render_callback(function ($fields, $attributes, $inner_blocks)
    {

        //Cria um slug com o título do slideshow
		$id = slugify($fields['titulo']);

		$colunas = $fields['coluna'];
        if ($colunas):			
			//HTML
			$corLinha = $fields['bg_cor_linha'];
			if($fields['bg_cor_linha'] != ''){$corLinha = 'style="background-color:'.$fields['bg_cor_linha'].'"';}

			echo '<div class="row" '.$corLinha.'>';
			
			foreach ($colunas as $coluna):
				//HTML DAS COLUNAS
				$col = 'class="col-md-12"';
				if($coluna['tamanho'] != ''){$col = 'class="col-md-'.$coluna['tamanho'].'"';}
				$bgcol = '';
				if($coluna['bg_cor'] != ''){$bgcol = ' style="background-color:'.$coluna['bg_cor'].'"';}
				$animac = '';
				if($coluna['animacao'] != 'nenhuma'){$animac = ' data-aos="'.$coluna['animacao'].'"';}
				$delay = '';
				if($coluna['delay'] != ''){$delay = ' data-aos-delay="'.$coluna['delay'].'"';}
				$padding = '';
				if($coluna['padding'] != ''){$padding = 'class="p-'.$coluna['padding'].'"';}

				echo '<div '.$col. $bgcol. $animac. $delay. $padding.'>';
				echo $coluna['conteudo'];
				echo '</div>';
				
			endforeach;

			echo '</div>';

        endif;
    });
}
add_action('carbon_fields_register_fields', 'colunas');


/**
 * Bloco Bullets Coloridos
 */
function bullets_colors()
{
    Block::make(__('MC Bullets Coloridos'))->add_fields(array(
        Field::make('text', 'titulo', __('Block Title')) ,
		Field::make( 'number', 'tamanho', 'Tamanho do Marcador' ),
		Field::make( 'select', 'formato', __( 'Formato do marcador' ) )->set_width(10)->set_required(true)
				->set_options( array(
					'circle' => 'circle',
					'square' => 'square',
				) ),
        Field::make('complex', 'lista', __('Counter'))
            ->set_layout('tabbed-horizontal')
            ->add_fields(array(
            Field::make('text', 'item_text', 'Ítem de lista')
                ->set_required(true)
                ->set_width(50) ,
			Field::make( 'color', 'bullet_color', __( 'Cor do marcador' ) )->set_width(10),
			Field::make( 'color', 'text_color', __( 'Cor do texto' ) )->set_width(10),
        )) ,		

    ))
        ->set_icon('editor-ul')
        ->set_keywords([__('BulletsColors') ])
        ->set_description(__('Bloco para lista com bullets coloridos.'))
		->set_category( 'custom-category', __( 'MC Blocks' ), 'smiley' )
        ->set_render_callback(function ($fields, $attributes, $inner_blocks)
    {

        //Cria um slug com o título do slideshow
		$id = slugify($fields['titulo']);

		$lista = $fields['lista'];
        if ($lista):
			echo '
			<div id="'.$id.'" class="lista-marcadores-coloridos">
				<ul style="list-style-type:' .$fields['formato']. ';">';	

			foreach ($lista as $item):
				echo '<li style="position:relative; color:'.$item['bullet_color'].'; font-size:' .$fields['tamanho']. 'rem;  line-height: ' .$fields['tamanho']. 'rem;">
				  <span style="display:block; position: absolute; top:0; left:0; color:'.$item['text_color'].'; font-size:1rem !important;"> '.$item['item_text'].'</span></li>';				
			endforeach;
			echo '</ul></div>';
			
        endif;
    });
}
add_action('carbon_fields_register_fields', 'bullets_colors');


/**
 * Bloco Accordion Simples
 */
function simple_accordion()
{
	Block::make( 'MC Accordion Simples' )
		->add_fields( array(
			Field::make( 'text', 'identidade', __( 'Nome único do bloco, todas minúsculas, sem espaços e sem acentos, exemplo: meu-id-unico' ) ),
			Field::make( 'rich_text', 'content', __( 'Conteúdo' ) ),
			Field::make( 'color', 'bg_color', __( 'Cor de fundo' ) )->set_width(10),
			Field::make( 'number', 'padding', 'Margem interna - padding - 1 a 5' )->set_width(10),				
		) )
		->set_description( __( 'Insira esse bloco na posição onde deverá ser aberto. 
		Um link ou botão com os seguintes atributos:  data-bs-toggle="collapse" href="#meu-id-unico" vai abrir o Accordion.' ) )
		->set_category( 'custom-category', __( 'MC Blocks' ), 'smiley' )
		->set_icon( 'editor-kitchensink' )
		->set_render_callback( function ( $block) {
 
			ob_start();
			?>
			<?php
				$padding = '';
				if($block['padding'] != ''){$padding = ' p-'.$block['padding'];}
			?>
			
			<div class="collapse<?php echo $padding; ?>" id="<?php echo $block['identidade']; ?>" 
			style="background-color:<?php echo $block['bg_color']; ?>">
				<?php echo $block['content']; ?>
			</div>					
 
			<?php
 
			return ob_get_flush();
		} );
}
add_action( 'carbon_fields_register_fields', 'simple_accordion' );
