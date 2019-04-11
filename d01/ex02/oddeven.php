#!/usr/bin/php
<?php
	echo "Entrez un nombre: ";
	while ($line = fgets(STDIN))
	{
		$line = rtrim($line, "\n");
		if (!is_numeric($line) || ctype_space($line[0]) || ctype_space($line[strlen($line) - 1]))
			echo "'".$line."' n'est pas un chiffre\n";
		else
		{
			if ($line % 2 == 0)
				echo "Le chiffre ".$line." est Pair\n";
			else
				echo "Le chiffre ".$line." est Impair\n";
		}
		echo "Entrez un nombre: ";
	}
	echo "\n";
?>