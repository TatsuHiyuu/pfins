<?php

	namespace GlobalBundle\Service;

	class Tool{

		/**
		 * Retourne le contenu avec les liens entre balise a
		 * @param string la chaine de caractére
		 * @param array tableau d'option
		 * @return string la chaine avec la balise href sur les liens
		 */
		public function autoLink($str, $attributes = array()) {
				
			$attrs = '';
			foreach ($attributes as $attribute => $value) {
				$attrs .= " {$attribute}=\"{$value}\"";
			}
		
			$str = ' ' . $str;
			$str = preg_replace(
				'`([^"=\'>])((http|https|ftp)://[^\s<]+[^\s<\.)])`i',
				'$1<a href="$2"'.$attrs.' target="_blank">$2</a>',
				$str
			);
			$str = substr($str, 1);
			
			return $str;
			
		}


        /**
         * Coupe une chaine de caractère et ajoute "..."
         * @param string la chaine de caractère
         * @param int le nombre de caractéres maximum
         * @return string
         */
        public function tronquer($description,$max_caracteres){

            if (strlen($description)>$max_caracteres){

                $description = substr($description, 0, $max_caracteres);
                $position_espace = strrpos($description, " ");

                if($position_espace == false)
                    $position_espace = strrpos($description, "-");

                $description = substr($description, 0, $position_espace);
                $description = $description."...";

            }

            return $description;

        }


	}

?>