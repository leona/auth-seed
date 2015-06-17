authSeed.computation = {
    initiate: function() {
        if (!Date.now) 
            Date.now = function() { return new Date().getTime(); }

        this.fetchSector();
        this.computation = '';
        this.charset     = 'qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM1234567890';
        this.auth_length = 6;
        
        return this;
    },
    fetch: function(key) {
        key = CryptoJS.MD5(this.sector  + key) + '';
        key = key.split('');
        
        for(i = 0;i <= key.length;i++) 
            this.computation = this.computation + this.charKey(key[i]);
       
        return this.computation.substring(0, this.auth_length);
    },
    charKey: function(char) {
        pos = this.charset.indexOf(char);
        pos = pos + '';

        if (pos.length > 1) 
            pos = pos.substring(pos.length - 1, pos.length);

        return pos;
    },
    fetchSector: function() {
        this.sector = Math.floor(Date.now() / 1000);
        this.sector = Math.round(this.sector / 120) * 120;

        return this.sector;
    }
}
