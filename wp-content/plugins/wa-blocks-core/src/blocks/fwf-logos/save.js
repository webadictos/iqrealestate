/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps, RichText } from '@wordpress/block-editor';

// import { Swiper, SwiperSlide } from 'swiper/react';
// import Swiper, { SwiperSlide } from 'swiper';
// import 'swiper/swiper-bundle.css'; // Importa los estilos CSS de SwiperJS

/**
 * The save function defines the way in which the different attributes should
 * be combined into the final markup, which is then serialized by the block
 * editor into `post_content`.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#save
 *
 * @return {Element} Element to render.
 */
export default function save(props) {
  const { images } = props.attributes;

  return (
    <div {...useBlockProps.save()}>
      <div className="wp-block-fw-festival-2024-fwf-logos__wrapper">
        {images.map(img => (
          <img
            src={img.url}
            alt=""
            width={img.maxWidth}
            height={(img.maxWidth / img.originalWidth) * img.originalHeight}
            key={img.id}
            className={`wp-block-fw-festival-2024-fwf-logos__img ${img.className}`}
          />
        ))}
      </div>
    </div>
  );
}
