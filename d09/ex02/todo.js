function new_todo()
{
	var saisie = prompt("Please enter your new task: ", "New Task")
	saisie = saisie.trim();
	console.log(saisie);
	if (saisie == "")
		return ;
	el = document.createElement("div");
	el.className = "task";
	el.textContent = saisie;
	var list = document.getElementById("ft_list")
	list.insertBefore(el, list.firstChild);
}

function del_todo(event)
{
	ev = event;
	if (event.target.className == "task")
	{
		if (confirm('Are you sure you want to delete this item: ' + event.target.textContent))
			event.target.remove();
		else
			return ;
	}
}
document.addEventListener("click", del_todo);
var ev;
