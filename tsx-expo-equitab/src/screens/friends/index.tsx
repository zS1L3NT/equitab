import { ScreenOptions as TopTabsScreenOptions } from "@/lib/top-tabs"
import { createMaterialTopTabNavigator } from "@react-navigation/material-top-tabs"
import AllTab from "./all"
import BlockedTab from "./blocked"
import IncomingTab from "./incoming"
import OutgoingTab from "./outgoing"

const Tab = createMaterialTopTabNavigator()

export default function FriendsScreen() {
	return (
		<Tab.Navigator initialRouteName="All" screenOptions={TopTabsScreenOptions}>
			<Tab.Screen name="All" component={AllTab} />
			<Tab.Screen name="Incoming" component={IncomingTab} />
			<Tab.Screen name="Outgoing" component={OutgoingTab} />
			<Tab.Screen name="Blocked" component={BlockedTab} />
		</Tab.Navigator>
	)
}
