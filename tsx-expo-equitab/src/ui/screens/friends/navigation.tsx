import { ScreenOptions as TopTabsScreenOptions } from "@/lib/top-tabs"
import { createMaterialTopTabNavigator } from "@react-navigation/material-top-tabs"
import AllTab from "./all"
import BlockedTab from "./blocked"
import IncomingTab from "./incoming"
import OutgoingTab from "./outgoing"

const FriendsTab = createMaterialTopTabNavigator<FriendsTabParamList>()
export type FriendsTabParamList = Record<"All" | "Incoming" | "Outgoing" | "Blocked", undefined>
export function FriendsTabNavigation() {
	return (
		<FriendsTab.Navigator initialRouteName="All" screenOptions={TopTabsScreenOptions}>
			<FriendsTab.Screen name="All" component={AllTab} />
			<FriendsTab.Screen name="Incoming" component={IncomingTab} />
			<FriendsTab.Screen name="Outgoing" component={OutgoingTab} />
			<FriendsTab.Screen name="Blocked" component={BlockedTab} />
		</FriendsTab.Navigator>
	)
}
