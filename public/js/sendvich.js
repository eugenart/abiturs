function openNav() {
	document.getElementById("myInformation").style.visibility = "visible";
	document.getElementById("myInformation").style.right = "0";
	document.getElementById("myInformation").style.overflow = "auto";
	document.getElementById("body").style.overflow = "hidden";
	document.getElementById("body").style.visibility = "hidden";
	document.getElementById("body").style.background = "var(--main-color)";
}

function closeNav() {
	document.getElementById("myInformation").style.visibility = "hidden";
	document.getElementById("myInformation").style.right = "-100%";
	document.getElementById("myInformation").style.overflow = "hidden";
	document.getElementById("body").style.overflow = "auto";
	document.getElementById("body").style.visibility = "visible";
	document.getElementById("body").style.background = "none";
}

// присваивание id всем элементам
var i = 0;
var list = [];
  $(".underline-row li a").each(function () {
	i++;
  list.push(this);
	$(this).attr("id", "item" + i);
});


function onClickAction(evt) {
  // Отменяем переход по ссылке
  evt.preventDefault();

  closeNav();

  var link = $(this).attr('href');

  document.location.href = link;

};

function clickLinks() {
	// Находим на странице кнопку и попап
	//console.log(list);

  list.forEach(a => {
    a.onclick = onClickAction;
});

	// Навешиваем на кнопку обработчик клика
}
$(document).ready(function () {
	clickLinks();
});
