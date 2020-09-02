export default {
    makeApiUrl(url) {
        return process.env.VUE_APP_API_URL + '/' + url;
    },

    apiError(error) {
        if (error.response === undefined) {
            return 'Ошибка! Не удалось связаться с API.';
        }
        let message = error.response.data.message;
        if (error.response.data.extra !== undefined) {
            message += this.getHandledExtra(error.response.data.extra);
        }

        return message;
    },

    getHandledExtra(extra) {
        let message = '';

        if (Array.isArray(extra)) {
            extra.forEach((item) => {
                message += '<br>' + item;
            });
        }

        if (extra.code !== undefined && extra.message !== undefined) {
            message += '<br>' + extra.code + ' - ' + extra.message;
        }

        return message;
    }
}