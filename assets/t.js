// Custom from https://github.com/roman-w3lifer-grinyov/yii2-i18n-js
const i18nJson = $.getJSON(`${UrlAll.home}/i18n`, function (result) {
  try {
    JSON.parse(result);
    return result;
  } catch (e) {
    return {};
  }
});
if (!("t" in window.yii)) {
  if (!document.documentElement.lang)
    throw new Error(
      'You must specify the "lang" attribute for the <html> element'
    );
  yii.t = (category, message, params, language) => {
    language = language || document.documentElement.lang;
    let translatedMessage;
    if (
      language === "{$sourceLanguage}" ||
      !i18nJson ||
      !i18nJson[category] ||
      !i18nJson[category][message] ||
      !i18nJson[category][message][language]
    )
      translatedMessage = message;
    else translatedMessage = i18nJson[category][message][language];
    if (params) {
      Object.keys(params).map(key => {
        // https://stackoverflow.com/a/6969486/4223982
        const escapedParam = key.replace(
          /[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g,
          "\\$&"
        );
        translatedMessage = translatedMessage.replace(
          new RegExp("\\{" + escapedParam + "\\}", "g"),
          params[key]
        );
      });
    }
    return translatedMessage;
  };
}
