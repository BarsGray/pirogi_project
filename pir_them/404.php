<?php
https://drive.google.com/file/d/1Q6EHvcaqyi45erxPnl__eq7W3ojEHEDE/view?usp=drive_link

.slick-dots {
  position: relative;
  display: flex;
  justify-content: center;
  gap: 12px;
}

.ios-indicator {
  position: absolute;
  top: 50%;
  left: 0;

  width: 10px;
  height: 10px;
  background: black;
  border-radius: 50%;

  transform: translate(0, -50%);
  transition: transform 0.4s ease;
}





😎












$('.slider').on('init', function (e, slick) {

  const dots = slick.$dots[0];

  const indicator = document.createElement('div');
  indicator.classList.add('ios-indicator');
  dots.appendChild(indicator);

  const gap = 12;
  const dotSize = 10;
  const step = dotSize + gap;

  function move(index) {
    indicator.style.transform =
      `translate(${index * step}px, -50%)`;
  }

  move(0);

  $(this).on('afterChange', function (e, slick, current) {
    move(current);
  });

});

$('.slider').slick({
  dots: true,
  arrows: false
});

?>