$map = @{}
Get-ChildItem src\Controller -Directory | Where-Object { $_.Name -notin 'Component' } | ForEach-Object {
  $p = $_.Name
  Get-ChildItem $_.FullName -Filter *Controller.php | ForEach-Object {
    $map[($_.BaseName -replace 'Controller$','')] = $p
  }
}
$utf8 = New-Object System.Text.UTF8Encoding $false
$files = Get-ChildItem templates,src -Recurse -Include *.php
foreach ($f in $files) {
  $t = [System.IO.File]::ReadAllText($f.FullName); $o = $t
  foreach ($c in $map.Keys) {
    $p = $map[$c]
    # prefix false / prefix lain -> prefix modul yang benar
    $t = [regex]::Replace($t, "'prefix'\s*=>\s*(false|null|'[A-Za-z]+')(\s*,\s*)'controller'\s*=>\s*'$c'", "'prefix' => '$p'`$2'controller' => '$c'")
    # link tanpa prefix sama sekali
    $t = [regex]::Replace($t, "(?<!'prefix'\s=>\s'[A-Za-z]{1,30}',\s)(?<!false,\s)(\[)\s*'controller'\s*=>\s*'$c'", "`$1'prefix' => '$p', 'controller' => '$c'")
  }
  if ($t -ne $o) { [System.IO.File]::WriteAllText($f.FullName, $t, $utf8); Write-Host "Updated $($f.Name)" }
}