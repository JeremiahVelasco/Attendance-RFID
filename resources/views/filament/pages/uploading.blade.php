<x-filament-panels::page>
    <style>
        #uploadForm {
            background: none;
            width: max-content;
            padding: 30px 30px;
            border: solid 1px #222224;
            border-radius: 15px;
        }

        #fileField {
            border: solid 1px #464649;
            border-radius: 6px;
            padding: 4px 6px;
        }

        #submitBtn {
            color: #ffffff;
            background: #133561;
            padding: 4px 12px;
            border-radius: 6px;
            font-weight: bold;
        }

        #submitBtn:hover {
            background: #556e8e;
        }
    </style>
    <section>
        <form id="uploadForm" action="">
            <input id="fileField" type="file">
            <button id="submitBtn" type="submit">Submit</button>
        </form>
    </section>
</x-filament-panels::page>
