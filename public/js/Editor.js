goog.provide("ko.fields.Editor");

goog.require("goog.dom.forms");
goog.require("goog.ui.Zippy");
goog.require("goog.ui.LabelInput");
goog.require('goog.i18n.DateTimeFormat');
goog.require('goog.i18n.DateTimeParse');
goog.require('goog.ui.InputDatePicker');
goog.require("goog.events.InputHandler");

ko.fields.Editor = (function () {
    var title,
        form,
        canvas,
        fields = {},
        conditionEvaluator,
        formFieldMap = {},
        /**@const*/DATE_PATTERN = "dd'-'MM'-'yyyy";

    function getParentGroupName(fieldName) {
        return fieldName.substring(0, fieldName.length - fieldName.split('.').pop().length - 1);
    }

    function focusField(fieldName) {
        if (fields.hasOwnProperty(fieldName)
                    && (fields[fieldName] instanceof goog.ui.LabelInput)) {
            var parentGroupName = getParentGroupName(fieldName);
            if (fields[parentGroupName]) {
                fields[parentGroupName].expand();
            }
            fields[fieldName].focusAndSelect();
        }
    }

    function addField(fieldName, displayName) {
        var fieldValue = conditionEvaluator.getUserFieldValue(fieldName),
            fieldType = conditionEvaluator.getUserFieldType(fieldName),
            fieldContainer = goog.dom.createDom('div'),
            input = goog.dom.createDom('span'),
            label = goog.dom.createDom('label'),
            labelInput,
            labelInputElement,
            datePicker,
            parentGroup,
            parentGroupZippy,
            supported = (fieldType === "string" || fieldType === "date" || fieldType === "currency");

        goog.dom.setProperties(label, {
            "for": fieldName
        });
        goog.dom.setProperties(input, {
            "id": fieldName
        });

        if (supported) {
            goog.dom.appendChild(fieldContainer, label);
            goog.dom.appendChild(fieldContainer, label);
            goog.dom.appendChild(form, fieldContainer);
            goog.dom.setTextContent(label, displayName);
            labelInput = new goog.ui.LabelInput(fieldValue);
            labelInput.render(label);

            // Listen to any input events on text fields and autosync
            labelInputElement = labelInput.getElement();
            goog.events.listen(new goog.events.InputHandler(labelInputElement),
                                goog.events.InputHandler.EventType.INPUT,
                                syncFields);

            if (fieldType === "date") {
                // Don't accept keyboard events. But picking a date from the popup should still work.
                labelInputElement.setAttribute('readonly', true);
                dateFormatter = new goog.i18n.DateTimeFormat(DATE_PATTERN),
                dateParser = new goog.i18n.DateTimeParse(DATE_PATTERN);
                datePicker = new goog.ui.InputDatePicker(dateFormatter, dateParser);
                datePicker.decorate(labelInputElement);
                // Sync fields whenever a new date is picked
                goog.events.listen(datePicker,
                                    goog.ui.DatePicker.Events.CHANGE,
                                    syncFields);
            }

            // Look for a group that should contain this
            parentGroupName = getParentGroupName(fieldName);
            if (fields[parentGroupName]) {
                parentGroupZippy = fields[parentGroupName];
                parentGroupZippy.getContentElement().appendChild(fieldContainer);
                fields[fieldName] = labelInput;
            }
        }
    }

    function addGroup(keyName, displayName) {
        var headerElement,
            contentElement,
            groupElement,
            headerImage;

        if (!fields[keyName]) {
            // Create Header
            headerElement = goog.dom.createDom('h2', {'class': 'groupHeader'}, displayName);
            headerImage = goog.dom.createDom('img', {'src': 'blank.gif'});
            goog.dom.insertChildAt(headerElement, headerImage, 0);
            // Create Content
            contentElement = goog.dom.createDom('div', {'class': 'groupContent'});
            // Create Grouping div
            groupElement = goog.dom.createDom('div', null, headerElement, contentElement);
            goog.dom.appendChild(form, groupElement);

            fields[keyName] = new goog.ui.Zippy(headerElement, contentElement);
        }
    }

    function getFormData() {
        var key,
            value,
            dataFields = {};

        for (key in fields) {
            if (fields.hasOwnProperty(key)
                    && (fields[key] instanceof goog.ui.LabelInput)) {
                value = fields[key].getValue() || fields[key].getLabel();
                dataFields[key] = value;
            }
        }

        return dataFields;
    }

    function populateForm() {
        var fieldNames = conditionEvaluator.getUserFieldNames(),
            fieldName;

        Object.keys(formFieldMap).map(function (fieldName) {
            if (fieldNames.indexOf(fieldName) === -1) {
                addGroup(fieldName, formFieldMap[fieldName]);
            } else {
                addField(fieldName, formFieldMap[fieldName]);
            }
        });
    }

    function syncFields() {
        var formData = getFormData(),
            key;

        for (key in formData) {
            if (formData.hasOwnProperty(key)
                    && (conditionEvaluator.getUserFieldValue(key) !== formData[key])) {
                conditionEvaluator.setUserFieldValue(key, formData[key]);
            }
        }

        conditionEvaluator.evaluate();
    }

    function Editor(docTitle, formElement, odfCanvas, fieldMap) {
        title = docTitle;
        form = formElement;
        canvas = odfCanvas;
        formFieldMap = fieldMap;
        conditionEvaluator = canvas.getConditionEvaluator();

        var titleDiv;

        // Display the title in a header
        titleDiv = goog.dom.createDom('h1');
        goog.dom.setTextContent(titleDiv, title);
        formElement.appendChild(titleDiv);

        // Populate the form
        populateForm();
    }

    Editor.prototype.focusField = focusField;

    return Editor;
})();
