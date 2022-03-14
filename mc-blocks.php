<?php
/*
Plugin Name: MC Blocks
Text Domain: mc-blocks
*/

use Carbon_Fields\Block;
use Carbon_Fields\Field;
 
defined( 'ABSPATH' ) || exit;


function mc_blocks_load() {
	require_once( 'vendor/autoload.php' );
	\Carbon_Fields\Carbon_Fields::boot();
}
add_action( 'after_setup_theme', 'mc_blocks_load' );


/**
 * Bloco imagem abre vídeo em janela modal
 */
function imagem_videomodal()
{
	Block::make( 'Imagem abre vídeo em janela modal' )
		->add_fields( array(
			Field::make( 'text', 'incorporacao', __( 'Código de incorporação (Youtube ou Vimeo)' ) ),
			Field::make( 'image', 'image', __( 'Imagem primeiro frame' ) ),
		) )
		->set_description( __( 'Bloco com imagem que abre um vídeo num modal.' ) )
		->set_category( 'custom-category', __( 'MC Blocks' ), 'smiley' )
		->set_icon( 'dashicons-admin-page' )
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
 * Bloco para vídeo em fullscreen
 */
function video_background()
{
	Block::make( 'Vídeo Background' )
		->add_fields( array(
			Field::make( 'image', 'url_video', __( 'Vídeo' ) )->set_type( array( 'image', 'video' ) ),
			Field::make( 'rich_text', 'content', __( 'Conteúdo' ) ),
		) )
		->set_description( __( 'Bloco para vídeo fullscreen formato mp4 da biblioteca.' ) )
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
 * Bloco para Sliders - carousel
 * Bootstrap 5
 */
function sliders_container()
{
	Block::make( 'complex', 'slider_show', __( 'Slider Show' ) )
	->set_inner_blocks( true )
	->add_fields( array(
		Field::make( 'text', 'title', __( 'Slide Title' ) ),
	) )
	->set_description( __( 'Container para slides. Adicione slides dentro desse bloco.' ) )
	->set_category( 'custom-category', __( 'MC Blocks' ), 'smiley' )		
	->set_icon( 'interactive' )
	->set_render_callback( function ( $block ) {

		ob_start();
		?>
			<!-- tags -->
			<?php var_dump($block['slider_show']); ?>

		<?php 
		return ob_get_flush();
	} );
}
add_action( 'carbon_fields_register_fields', 'sliders_container' );


function slide()
{
	Block::make( 'Slide de imagens' )
		->add_fields( array(
			Field::make( 'text', 'legenda', __( 'Legenda do Slide' ) ),
			Field::make( 'text', 'url', __( 'Link do slide' ) ),
			Field::make( 'image', 'imagem', __( 'Imagem do slide' ) ),
		) )
	->set_description( __( 'Slides em carousel. Inserir' ) )
	->set_category( 'custom-category', __( 'MC Blocks' ), 'smiley' )		
	->set_icon( 'interactive' )
	->set_render_callback( function ( $block ) {

		ob_start();
		?>
			<!-- tags -->

		<?php 
		return ob_get_flush();
	} );
}
add_action( 'carbon_fields_register_fields', 'slide' );



/**
 * Bloco para simulação de financiamento
 * Bootstrap 5
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
