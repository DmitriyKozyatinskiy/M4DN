<template>
    <div v-for="(visits, index) in visitGroups">
        <div class="History__Header">{{ index }}</div>

        <div v-for="visit in visits" class="clearfix History__Row">
            <div class="col-xs-1 History__Col">
                <span title="{{ visit.created_at }}">
                  {{ visit.created_at }}
                </span>
            </div>
            <div class="col-xs-1  History__Col">
                <span title="{{ visit.device.userAgent }}">{{ visit.device.name }}</span>
            </div>
            <div class="col-xs-5 History__Col">
                <a href="{{ visit.url }}" title="{{ visit.url }}">{{ visit.url }}</a>
            </div>
            <div class="col-xs-5 History__Col">
                <span title="{{ visit.title }}">{{ visit.title }}</span>
            </div>
        </div>
        <br>
    </div>
</template>
