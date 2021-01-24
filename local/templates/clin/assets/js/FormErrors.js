

class FormErrors {
    //_form; сафари такого не понимает
    //_fieldClass;
    //_textFieldClass;

    constructor($form, fieldClass = 'error', textFieldClass = 'error-text') {
        this._form = $form;
        this._fieldClass = fieldClass; //error field class
        this._textFieldClass = textFieldClass; //field class with error text
    }

    _setError(error) {
        this._form.append(error);
    }

    _setFieldError($element, error) {
        if ($element.length > 0) {
            $element.addClass(this._fieldClass);
            $element.after(error);
        } else {
            this._setError(error);
        }
    }

    _createErrorBlock(text) {
        return "<span class='" + this._textFieldClass + "'>" + text + "</span>";
    }

    setErrors(errors) {
        let $this = this;

        $this.removeErrors();

        $.each(errors, function(index, value) {
            if (this.customData !== null) {
                if (typeof(this.customData['field_name']) !== "undefined") {
                    let $element;

                    if (typeof(this.customData['neighbour_selector']) !== "undefined") {
                        $element = $this._form.find("[name='" + this.customData['field_name'] + "']").siblings(this.customData['neighbour_selector']).first();
                    } else {
                        $element = $this._form.find("[name='" + this.customData['field_name'] + "']");
                    }

                    $this._setFieldError(
                        $element,
                        $this._createErrorBlock(this.message)
                    );
                }
            } else {
                $this._setError(
                    $this._createErrorBlock(this.message)
                );
            }
        });
    }

    removeErrors() {
        let $this = this;

        this._form.find('.' + $this._fieldClass).each(function() {
            $(this).removeClass($this._fieldClass);
        });
        this._form.find('.' + $this._textFieldClass).each(function() {
            $(this).remove();
        });
    }
}
