$targetPath = 'c:\Users\jesus\Documents\AEM\VASS\puig\code\puig-cloud\core\src\main\java\com\puig\ifb'
$files = Get-ChildItem -Path $targetPath -Recurse -Filter *.java

foreach ($f in $files) {
    if ($f.Name -eq 'IfbBaseServlet.java' -or $f.Name -eq 'SupplierServlet.java') { continue }
    $content = Get-Content -Path $f.FullName -Raw
    
    if ($content -match '(?<!ServletUtils\.)(?:this\.)?(setResponseBody|setErrorResponseBody|setOkResponseBody)\(') {
        $newContent = [regex]::Replace($content, '(?<!ServletUtils\.)(?:this\.)?(setResponseBody|setErrorResponseBody|setOkResponseBody)\(', 'ServletUtils.$1(')
        
        if ($newContent -notmatch 'import com\.puig\.commons\.core\.utils\.ServletUtils;') {
            $newContent = [regex]::Replace($newContent, '(?m)^(package\s+[\w\.]+;)', "`$1`r`nimport com.puig.commons.core.utils.ServletUtils;")
        }
        
        if ($content -ne $newContent) {
            $Utf8NoBomEncoding = New-Object System.Text.UTF8Encoding $False
            [System.IO.File]::WriteAllText($f.FullName, $newContent, $Utf8NoBomEncoding)
            Write-Host "Modified $($f.Name)"
        }
    }
}
