// kpiDetails.js
(function() {

    const kpiDetailText = {
            "KPI 1.1": "Increased number of church members participating in both personal and public evangelistic outreach initiatives with a goal of Total Member Involvement (TMI).",
            "KPI 1.2": "Frontline missionaries speak at major camp meetings and at other large church gatherings.",
            "KPI 1.3": "Each division holds annual mission rallies for church members.",
            "KPI 1.4": "Create and make available age-appropriate mission-focused morning devotional books aimed at each grade level of elementary education.",
            "KPI 1.5": "Collaboration in producing readings on mission for Adventist children and teenagers.",
            "KPI 1.6": "GC-funded periodicals include at least one story from the 10/40 Window or large urban areas in every issue.",
            "KPI 1.7": "Improved retention rates of audited membership globally.",
            "KPI 2.1": "A worshipping group is established in each country of the 10/40 Window where there currently is no Seventh-day Adventist presence.",
            "KPI 2.2": "Each conference, mission, and region in the 10/40 Window achieves a demonstrable increase in the number of new believers.",
            "KPI 2.3": "Demonstrable increase in total members and congregations in all urban areas of one million people or more.",
            "KPI 2.4": "At least one Center of Influence operates in each urban area of one million people or more.",
            "KPI 2.5": "GC departments facilitate, initiate, and liaise between interdivisional mission projects.",
            "KPI 2.6": "Each conference and mission outside the 10/40 Window has a five-year plan to achieve a measurable and significant increase in the number of newly planted worshipping groups.",
            "KPI 2.7": "Each division identifies all significant immigrant/refugee populations in their territories, has initiatives in place to reach them.",
            "KPI 2.8": "Each GC department has programs in place responding to global trends in immigration.",
            "KPI 2.9": "Each conference and mission has a five-year plan to increase the number of Adventist primary and secondary schools.",
            "KPI 2.10": "Division presidents report regularly to the GC Executive Committee on progress in achieving KPIs relating to Objective no. 2.",
            "KPI 3.1": "Each division undertakes interfaith dialogs.",
            "KPI 3.2": "Global Mission Center directors present progress reports on dialogs to the 2023 and 2025 meetings of the Global Mission Issues Committee.",
            "KPI 3.3": "Global Mission Centers report yearly to Annual Council on approaches to, and progress in, reaching world religions and belief systems.",
            "KPI 4.1": "Mission initiatives in the 10/40 Window and large urban areas receive assistance from institutions elsewhere in the world.",
            "KPI 4.2": "Adventist tertiary institutions increase the proportion of missiologists teaching mission.",
            "KPI 4.3": "Each institution reports to its board or governing committee on how it will achieve selected objectives and KPIs of the I Will Go plan.",
            "KPI 5.1": "Significant increase in numbers of church members regularly praying, studying the Bible, using the Sabbath School Bible Study Guides, reading the writings of Ellen White and engaging in other personal devotions.",
            "KPI 5.2": "Significant increase in numbers of church members and unbaptized children and youth regularly attending divine service and Sabbath School.",
            "KPI 5.3": "Significant increase in acceptance and practice of the churchs distinctive beliefs.",
            "KPI 5.4": "Increased number of people using Adventist social media when studying the Bible, to learn about Ellen White and read her writings, in personal devotions, and to promote mission.",
            "KPI 5.5": "Increased number of local churches and individuals using Hope Channel, AWR, Adventist World, and other official church publications and media.",
            "KPI 5.6": "Increased number of church members and church school students participating in corporate prayer initiatives.",
            "KPI 5.7": "Evidence of better understanding of the prophetic role of Ellen White and the process of inspiration.",
            "KPI 5.8": "Increased availability in local languages of Ellen Whites writings in print, braille and audiobooks, on websites, mobile devices, and social media.",
            "KPI 5.9": "Increased number of children from Adventist homes and churches attending Adventist schools.",
            "KPI 6.1": "Increased church member involvement in fellowship and service, both in the church and in the local community.",
            "KPI 6.2": "Evidence of greater unity and community among church members, of reduced conflict in local churches, and of an active commitment to zero tolerance of physical, emotional, and sexual abuse.",
            "KPI 6.3": "Evidence of new members being nurtured through active discipleship programs.",
            "KPI 6.4": "Significant increase in number of church members regularly engaging in family worships.",
            "KPI 6.5": "All members and yet-to-be-baptized young people embrace and practice stewardship principles regarding time, spiritual gifts, and tithes and offerings.",
            "KPI 6.6": "Church members exhibit cross-cultural understanding and respect for all people.",
            "KPI 6.7": "Evidence that local churches and Adventist schools are responding to the opportunities that mass migration offers for ministry, and that immigrants are being integrated into local Adventist communities.",
            "KPI 6.8": "Improved retention rates of young adults, youth, and unbaptized children, based on the collection of specific statistics on those groups.",
            "KPI 7.1": "Bible classes teach the historical-grammatical method, historicist approach to the study of prophecies, confidence in the Bible as divine revelation, trust in God, and commitment to His mission.",
            "KPI 7.2": "Youth and young adults embrace the belief (FB 22) that the body is the temple of the Holy Spirit, abstaining from alcohol, tobacco, recreational use of drugs and other high-risk behaviors, and embrace church teachings (FB 23) on marriage, and demonstrate sexual purity.",
            "KPI 7.3": "Increased ethical and responsible use of media platforms by students.",
            "KPI 8.1": "Evidence that most pastors and teachers feel supported by church members and by conference administrators, continue to feel called to ministry, and are engaging in continuing education and development.",
            "KPI 8.2": "Pastors with limited Seventh-day Adventist education are working to complete course work necessary to meet their local BMTE requirements.",
            "KPI 8.3": "Opportunities are given to frontline workers to deepen their passion for and broaden their experience of mission.",
            "KPI 9.1": "Every organization systematically reviews and aligns resources in light of the worldwide mission priorities.",
            "KPI 9.2": "All GC departments increase the availability of their time and resources to the 10/40 Window, large urban areas, and unreached people groups, and GC Treasury presents a report on departmental use of time and resources to the 2023 Spring Meeting of the GC Mission Board.",
            "KPI 9.3": "Increased proportion of international service personnel, volunteers, and Global Mission pioneers serving in the 10/40 Window, in large urban areas, and among unreached people groups.",
            "KPI 9.4": "The GC Treasury appropriations review team recommends to Annual Council ways to allocate more appropriations to the 10/40 Window, large urban areas, and unreached people groups.",
            "KPI 9.5": "The General Conference has, and its entities are working toward, an integrated media plan that maximizes the potential of technology.",
            "KPI 9.6": "GC Stewardship Ministries develops and implements a well-defined strategy for achieving increases in tithe and offerings in each organizational unit that reflect changes in membership and inflation.",
            "KPI 9.7": "Each division has a Stewardship Ministries director who has no other responsibilities in his/her portfolio.",
            "KPI 10.1": "Widespread adoption of approved membership software to enhance accuracy and accountability of records of local church membership",
            "KPI 10.2": "An orientation process for officers and executive committee members of all units of denominational structure is developed and widely implemented",
            "KPI 10.3": "Evidence that pastors and church leaders demonstrate the highest standards of integrity and ethical behavior in interpersonal relations and finances",
            "KPI 10.4": "Divisions annually report progress in achieving the objectives and KPIs of the I Will Go plan: both via an online form, with standardized summative information, and by a presentation at each Annual Council",
            "KPI 10.5": "Quinquennial reports of GC departments, institutions, and agencies to Annual Council focus on their contribution to achieving the objectives and KPIs of the I Will Go plan."   
    };
    
    function updateKpiDetails(selectedValue) {
        const kpiDetails = document.getElementById("kpiDetails");
        const editKpiDetails = document.getElementById("editKpiDetails");
        if (kpiDetails) {
            console.log(`Updating KPI create details for: ${selectedValue}`);
            kpiDetails.textContent = kpiDetailText[selectedValue] || "Key performance indicator details";
        } 
        // Update edit goal modal if editKpiDetails exists
        if (editKpiDetails) {
            console.log(`Updating KPI edit details for: ${selectedValue}`);
            
            const kpiDetailContent = kpiDetailText[selectedValue];
            console.log(`KPI Detail Content: ${kpiDetailContent}`);
    
            editKpiDetails.textContent = kpiDetailContent || "Key performance indicator details";
        }
            if (!kpiDetails && !editKpiDetails)  {
            console.error("Element with id 'kpiDetails' not found.");
        }
    }
    
    
    function setupKpiDropdownListener(dropdownId) {
        const dropdown = document.getElementById(dropdownId);
        if (dropdown) {
            console.log(`Setting up listener for dropdown with id: ${dropdownId}`);
            dropdown.addEventListener('change', function() {
                const selectedValue = this.value;
                console.log(`Dropdown value changed to: ${selectedValue}`);
                updateKpiDetails(selectedValue);
            });
        } else {
            console.error(`Dropdown with id '${dropdownId}' not found.`);
        }
    }
    
    // Set up listeners for modals
    setupKpiDropdownListener("createInitiative"); // For Create Goal modal
    setupKpiDropdownListener("editInitiative");   // For Edit Goal modal
    
    })();