    <!-- Link JS -->
    <script>
        function copyText() {
            var text = document.getElementById("textToCopy").innerText;
            var textarea = document.createElement("textarea");
            textarea.value = text;
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand("copy");
            document.body.removeChild(textarea);
            alert("Text copied!");
        }
        function copyText2() {
            var text = document.getElementById("textToCopy2").innerText;
            var textarea = document.createElement("textarea");
            textarea.value = text;
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand("copy");
            document.body.removeChild(textarea);
            alert("Text copied!");
        }
        function copyText3() {
            var text = document.getElementById("textToCopy3").innerText;
            var textarea = document.createElement("textarea");
            textarea.value = text;
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand("copy");
            document.body.removeChild(textarea);
            alert("Text copied!");
        }
    </script>
    <script src="../layout/js/jquery-3.7.1.min.js"></script>
    <script src="../layout/js/main.js"></script>
    <script src="../layout/js/all.min.js"></script>
    <script src="../layout/js/bootstrap.bundle.min.js"></script>
    

</body>

</html>