<div class="feed">
	<form method="POST">
		<textarea name="msg" class="textareapost"></textarea><br/>
		<input type="submit" value="Enviar" />
	</form>

	<?php foreach($feed as $item): ?>
	<strong><?php echo $item['nome']; ?></strong> - <?php echo date('H:i', strtotime($item['data_post'])); ?><br/>
	<?php echo $item['mensagem']; ?>
	<hr/>
	<?php endforeach; ?>
</div>
<div class="rightside">
	<h4>Relacionamentos</h4>
	<div class="rs_meio"><?php echo $qt_seguidores; ?><br/>Seguidores</div>
	<div class="rs_meio"><?php echo $qt_seguidos; ?><br/>Seguindo</div>
	<div style="clear:both"></div>

	<h4>Sugestões de amigos</h4>
	<table border="0" width="100%">
		<tr>
			<td width="80%"></td>
			<td></td>
		</tr>
		<?php foreach($sugestao as $usuario): ?>
		<tr>
			<td><?php echo $usuario['nome']; ?></td>
			<td>
				<?php if($usuario['seguido']=='0'): ?>
				<a href="/twitter/home/seguir/<?php echo $usuario['id']; ?>">Seguir</a>
				<?php else: ?>
				<a href="/twitter/home/deseguir/<?php echo $usuario['id']; ?>">Deseguir</a>
				<?php endif; ?>
			</td>
		</tr>
		<?php endforeach; ?>
	</table>
</div>