	<?php if (!empty($data)): ?>
		<div class="tabbable" style="margin-top: -10px;"> 
			<ul class="nav nav-tabs">
				<?php
				foreach ($data as $value) {
					$url = explode('?', $value['url']);
					if (isset($url[0]))
						$url = $url[0];
					else
						$url = $value['url'];

					$value['url'] = (!empty($value['url']) && $value['url'] != '#' ? Constant::baseUrl().'/'.$value['url'] : 'javascript:void(0);');

					$icon = (isset($value['icon']) ? '<i class="fa '.$value['icon'].'"></i>' : '');
					echo '<li class="'.($this->route == $url ? "active" : "").'">'.
					'<a href="'. $value['url'] .'">'.$icon.' '. $value['label'] .'</a>'.
					'</li>';
				}
				?>
			</ul>
		</div>

		<div class="divider"></div>

		<?php endif; ?>